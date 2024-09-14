<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();

        // If there are no users or posts, create some
        if ($users->isEmpty()) {
            User::factory(10)->create();
            $users = User::all();
        }
        if ($posts->isEmpty()) {
            $this->call(PostSeeder::class);
            $posts = Post::all();
        }

        // Create 200 comments
        Comment::factory(200)->make()->each(function ($comment) use ($users, $posts) {
            $comment->user_id = $users->random()->id;
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });
    }
}
