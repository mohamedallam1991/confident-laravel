<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'ordinal' => $faker->randomDigitNotNull,
        'product_id' => null,
        //
    ];
});
