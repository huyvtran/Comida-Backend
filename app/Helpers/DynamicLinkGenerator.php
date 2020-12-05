<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class DynamicLinkGenerator
{
    public static function create($token)
    {
        $apiKey = env('FIREBASE_API_KEY');
        $domainLink = env('FIREBASE_DOMAIN_DYNAMIC_LINK');
        $baseURL = env('FIREBASE_BASE_URL');
        $deepLink = env('FIREBASE_DEEP_LINK');
        $appPackage = env('FIREBASE_PACKAGE_NAME');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])

        ->post($baseURL . '?key=' . $apiKey, [
            "dynamicLinkInfo" => [
                "domainUriPrefix" => $domainLink,
                "link"=> $deepLink . '?token=' . $token,
                "androidInfo" => [
                    "androidPackageName" => $appPackage,
                ],
                "iosInfo" => [
                    "iosBundleId" => $appPackage,
                ],
            ],
        ]);

        return json_decode($response->body());
    }
}
