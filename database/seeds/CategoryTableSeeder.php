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

        DB::table('categories')->insert([
            'title' => 'About us ',
            'slug' => slug(strtolower('About us')),
            'description' => 'This stores the information about about us.',
            'position'=>1,
            'attributes'=>
                json_encode([])
        ]);

        DB::table('categories')->insert([
            'title' => 'Feature Content',
            'slug' => slug(strtolower('Feature Content')),
            'description' => 'This stores the information about feature Content.',
            'position'=>2,
            'attributes'=>
                json_encode([])
        ]);

        DB::table('categories')->insert([
            'title' => 'Features',
            'slug' => slug(strtolower('Features')),
            'description' => 'This stores the information about us.',
            'position'=>3,
            'attributes'=>
                json_encode([])


        ]);

        DB::table('categories')->insert([
            'title' => 'Blogs',
            'slug' => slug(strtolower('Blogs')),
            'description' => 'This stores the information about us.',
            'position'=>4,
            'attributes'=>
                json_encode([])

        ]);
        DB::table('categories')->insert([
            'title' => 'CTA Category ',
            'slug' => slug(strtolower('Extra Category')),
            'description' => 'This stores the information about cta Category.',
            'position'=>5,
            'attributes'=>
                json_encode([])
        ]);

    }
}
