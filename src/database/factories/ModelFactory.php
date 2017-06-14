<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(SystemInc\LaravelAdmin\Admin::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(SystemInc\LaravelAdmin\Page::class, function (Faker\Generator $faker) {
    return [
        'title'             => $faker->sentence,
        'elements_prefix'   => $faker->name,
        'slug'              => $faker->sentence,
        'description'       => $faker->text,
        'keywords'          => $faker->title,
    ];
});
