<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
		'title' => $faker->sentence,
		'content' => nl2br(implode("\n", $faker->paragraphs)),
		'photo' => $faker->image('./storage/app/public/posts/', 640, 480, 'cats', false),
		'published_at' => now()
    ];
});
