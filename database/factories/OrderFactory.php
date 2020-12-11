<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->numberBetween(1, 1000),
        'user_id' => $faker->unique()->numberBetween(1, 10000),
        'total_price' => $faker->randomNumber,
        'note' => Str::random(100),
        'status' => $faker->numberBetween(1, 4),
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'created_at' => new DateTime,
        'updated_at' => new DateTime,
        'deleted_at' => null,
    ];
});
