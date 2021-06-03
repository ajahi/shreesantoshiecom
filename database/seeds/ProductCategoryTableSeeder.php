<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;
use Illuminate\Support\Str;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'title'=>'bag',
            'description'=>'this is a bag',
            'slug'=>'bag',
            'position'=>1
        ]);
        ProductCategory::create([
            'title'=>'apparel',
            'description'=>'this is apparel',
            'slug'=>'apparel',
            'position'=>2
        ]);
    }
}
