<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Technology',
            'Health',
            'Lifestyle',
            'Sports',
            'Politics',
            'Entertainment',
            'Science',
            'Business',
            'Education',
            'Travel'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
