<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use mms80\TodoApi\Label;
use Faker\Generator as Faker;

$factory->define(Label::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->name
    ];
});
