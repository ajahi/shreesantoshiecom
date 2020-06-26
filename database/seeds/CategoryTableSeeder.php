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
            'title' => 'Blogs',
            'slug' => slug(strtolower('Blogs')),
            'description' => 'This store the information of blog category',
            'position'=>4,
            'attributes'=>
                json_encode([])

        ]);

    }
}
