<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\PasswordValidationRules;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\SendResetPasswordDeepLink;
use App\Mail\SendVerificationCode;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\VerificationSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use PasswordValidationRules;

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Success get user profile');
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'Validation Errors', 500);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Unathorized',
            ], 'Authentication Failed', 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->password, $user->password, [])) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Invalid Credentials',
            ], 'Authentication Failed', 422);
        }
        else if (!$user->email_verified_at) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Email not verified yet',
            ], 'Authentication Failed', 450);
        }

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => $user
        ], 'Authenticated');
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'phone_number' => ['required', 'string', 'min:9', 'max:16', 'unique:users'],
            'address' => ['required', 'string', 'min:9'],
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'Validation Errors', 500);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        UserAddress::create([
            'user_id' => $user->id,
            'type' => "Home",
            'address' => $request->address,
        ]);

        $verfication = VerificationSession::create([
            'user_id' => $user->id,
            'code' => rand(0000, 9999),
            'expired_at' => Carbon::now()->addHour(),
        ]);

        Mail::to($user->email)->send(new SendVerificationCode($user->name, $verfication->code));

        return ResponseFormatter::success([
            'access_token' => null,
            'token_type' => null,
            'user' => new UserResource($user),
        ], 'User Registered');
    }

    public function verify(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'code' => ['required', 'string', 'size:4'],
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'VeValidation Errors', 500);
        }

        $matchCode = VerificationSession::where([
            ['user_id', '=', $request->user_id],
            ['code', '=', $request->code],
        ])->first();

        if (!$matchCode) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Wrong verification code or User not found',
            ], 'Verification Failed', 400);
        }
        else if (Carbon::parse($matchCode->expired_at)->millisecond() <= Carbon::now()->millisecond()) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Code has expired',
            ], 'Verification Failed', 422);
        }

        $user = User::find($request->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        $matchCode->delete();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return ResponseFormatter::success([
            'access_token' => $tokenResult,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ], 'User Verified');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function sendReset(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'Validation Errors', 500);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Email is not registered',
            ], 'Authentication Failed', 400);
        }

        $token = $user->createToken('resetToken')->plainTextToken;
        $deepLink = 'https://tinyurl.com/y5s44ryj?token='.$token;

        Mail::to($user->email)->send(new SendResetPasswordDeepLink($user->name, $deepLink));

        return ResponseFormatter::success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Reset Password Sent');
    }

    public function resetPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => $this->passwordRules(),
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'Validation Errors', 500);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => 'Email is not registered',
            ], 'Authentication Failed', 400);
        }

        User::where('email', $user->email)->update([
            'password' => Hash::make($request->password),
        ]);

        return ResponseFormatter::success('Congratulations', 'Password Has Been Reset');
    }

    public function updateProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
            'phone_number' => ['required', 'string', 'min:9', 'max:16', 'unique:users,email,'.$request->id],
            'address' => ['required', 'string', 'min:9'],
        ]);

        if ($validate->errors()->count() != 0) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $validate->errors(),
            ], 'Validation Errors', 500);
        }

        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user,'Profile Updated');
    }
}
