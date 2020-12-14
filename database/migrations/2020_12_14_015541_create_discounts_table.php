<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id');
            $table->foreignId('offer_id')->nullable();
            $table->string('title');
            $table->tinyInteger('discount');
            $table->string('code', 20);
            $table->timestamps();

            $table->foreign('food_id')->references('id')->on('foods')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('offer_id')->references('id')->on('offers')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
