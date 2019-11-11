<?php

use App\Category;
use Faker\Factory;
use Illuminate\Database\Seeder;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            Category::create([
                'title'=>$faker->title,
                'description' => $faker->paragraph,
                'position' => $faker->numberBetween(1,100)
            ]);

        }
    }
}
