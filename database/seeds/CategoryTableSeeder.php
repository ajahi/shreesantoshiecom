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
            'title' => 'Features',
            'slug' => slug(strtolower('Features')),
            'description' => 'This stores the information about us.',
            'position'=>1

        ]);
        DB::table('categories')->insert([
            'title' => 'Feature Text',
            'slug' => slug(strtolower('Feature Text')),
            'description' => 'This stores the information about us.',
            'position'=>2
        ]);
        DB::table('categories')->insert([
            'title' => 'Blogs',
            'slug' => slug(strtolower('Blogs')),
            'description' => 'This stores the information about us.',
            'position'=>3

        ]);
        DB::table('categories')->insert([
            'title' => 'Category four ',
            'slug' => slug(strtolower('Category Four')),
            'description' => 'This stores the information about us.',
            'position'=>4
        ]);

    }
}
