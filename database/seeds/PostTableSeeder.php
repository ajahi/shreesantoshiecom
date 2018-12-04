<?php

use App\Modules\Category\Models\Category;
use App\Modules\Post\Models\Post;
use Illuminate\Database\Seeder;
use Faker\Factory;



class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $category = Category::pluck('id')->toArray();;

        for ($i = 0; $i < 50; $i++) {
            Post::create([
                'title'=>$faker->title,
                'category_id' => $category[rand(0, count($category) - 1)],
                'status' => $faker->randomElement($array = array ('published','draft')),
                'icon' => 'fa-none',
                'description' => $faker->paragraph,
            ]);

        }

    }
}
