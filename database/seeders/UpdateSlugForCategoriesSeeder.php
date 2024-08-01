<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateSlugForCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = DB::table('categories')->get();

        foreach ($categories as $category) {
            if (empty($category->slug)) {
                DB::table('categories')
                    ->where('id', $category->id)
                    ->update(['slug' => Str::slug($category->name) . '-' . Str::random(5)]);
            }
        }
    }
}
