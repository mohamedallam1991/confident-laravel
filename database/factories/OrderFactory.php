<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Order;
use App\Coupon;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id; // id of the user created
        },
        'product_id' => function(){
            return 1;
            //return factory(Product::class)->create()->id; // id of the product created
        },
        'coupon_id' => function(){
            return factory(Coupon::class)-> create()->id;
        },
        'stripe_id' => $faker->word, // stripe id key
        'total' => $faker->randomFloat(), // price float
        //
    ];
});
