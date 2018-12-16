<?php

use App\Category;
use Illuminate\Database\Seeder;

use Faker\Factory;


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

        for ($i = 0; $i < 50; $i++) {
            Category::create([
                'title'=>$faker->title,
                'description' => $faker->paragraph,
                'position' => $faker->numberBetween(1,100)
            ]);

        }
    }
}
