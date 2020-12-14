<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('transaction_id');
            $table->json('info');
            $table->timestamps();

            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->cascadeOnUpdate()->nullOnDelete();
            $table->foreign('transaction_id')->references('id')->on('transactions')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
