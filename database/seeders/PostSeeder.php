<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Make sure we have some users and categories
        $users = User::all();
        $categories = Category::all();

        // If there are no users or categories, create some
        if ($users->isEmpty()) {
            User::factory(10)->create();
            $users = User::all();
        }
        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        // Create 50 posts
        Post::factory(50)->make()->each(function ($post) use ($users, $categories) {
            $post->user_id = $users->random()->id;
            $post->save();

            // Attach 1-3 random categories to each post
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
