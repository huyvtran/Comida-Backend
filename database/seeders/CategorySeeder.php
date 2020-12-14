<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            [
                'name' => 'Burger',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fburger_category.jpg?alt=media&token=6ff1bb5a-5257-4e4f-b366-e30b411aa310',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chicken',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fchicken_category.jpg?alt=media&token=583aab54-744e-4a6c-8e9c-c96ef53bf863',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Drink',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fdrink_category.jpg?alt=media&token=7c8b08ca-67cd-437f-a915-ec827ebab7ce',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Hot Dog',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fhotdog_category.jpg?alt=media&token=6b246b41-3d0a-4858-af50-64235aa8cd9c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lasagna',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Flasagna_category.jpg?alt=media&token=bf2b1af4-26ff-4ffa-9e36-737d8be99add',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pancake',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fpancake_category.jpg?alt=media&token=a84bf4d9-cc7b-46f7-9dfa-ae4612589f07',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pasta',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fpasta_category.jpg?alt=media&token=756e5944-eee0-4157-9700-921f44a1e373',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pizza',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fpizza_category.jpg?alt=media&token=b37a6284-e176-466c-b8c9-8e9e5316428c',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rissoto',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Frissoto_category.jpg?alt=media&token=952369c2-68ea-4a60-a47b-9f0a97cc530a',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sandwich',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fsandwich_category.jpg?alt=media&token=4d9d0d8a-6af8-4fc8-9479-49ff4bcc5b81',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Seafood',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fseafood_category.jpg?alt=media&token=e5bf62a6-0559-40aa-a51a-61cb1719c0d2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Steak',
                'image' => 'https://firebasestorage.googleapis.com/v0/b/comida-bdc17.appspot.com/o/categories%2Fsteak_category.jpg?alt=media&token=40835f74-74d2-4633-ae28-d5a4e59fe459',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
