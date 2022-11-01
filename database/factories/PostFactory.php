<?php

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'title' => $faker->title,
        'subtitle' => $faker->sentence,
        'text' => $faker->text,
    ];
});
