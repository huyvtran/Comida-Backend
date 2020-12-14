<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_id');
            $table->string('name');
            $table->string('rating', 3, 2)->default(0)->nullable();
            $table->double('price', 10, 2);
            $table->mediumText('description')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();

            $table->foreign('food_id')->references('id')->on('foods')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_types');
    }
}
