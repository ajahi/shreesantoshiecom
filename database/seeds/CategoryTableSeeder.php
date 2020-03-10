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
            'description' => 'This stores the information of about us category',
            'position'=>1,
            'attributes'=>
                json_encode([])
        ]);

        DB::table('categories')->insert([
            'title' => 'Feature Content',
            'slug' => slug(strtolower('Feature Content')),
            'description' => 'This store the information of feature Content category',
            'position'=>2,
            'attributes'=>
                json_encode([])
        ]);

        DB::table('categories')->insert([
            'title' => 'Features',
            'slug' => slug(strtolower('Features')),
            'description' => 'This store the information of features category.',
            'position'=>3,
            'attributes'=>
                json_encode([])


        ]);

        DB::table('categories')->insert([
            'title' => 'Blogs',
            'slug' => slug(strtolower('Blogs')),
            'description' => 'This store the information of blog category',
            'position'=>4,
            'attributes'=>
                json_encode([])

        ]);
        DB::table('categories')->insert([
            'title' => 'CTA Category ',
            'slug' => slug(strtolower('Extra Category')),
            'description' => 'This store the information of cta category.',
            'position'=>5,
            'attributes'=>
                json_encode([])
        ]);
        DB::table('categories')->insert([
            'title' => 'Pricing ',
            'slug' => slug(strtolower('Pricing')),
            'description' => 'This store the information of pricing category',
            'position'=>6,
            'attributes'=>
                json_encode([])
        ]);

    }
}
