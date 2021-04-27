<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Coupon;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'code' => $faker->md5,  // string
        'percent_off' => $faker->numberBetween(1, 100),//integer
        'expired_at' => null,  //timesamps
    ];
});
