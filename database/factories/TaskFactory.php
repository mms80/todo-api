<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use mms80\TodoApi\Task;
use mms80\TodoApi\User;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'user_id' => factory(mms80\TodoApi\User::class),
        'title' => $faker->name,
        'description' => $faker->text,
        'status' => 1,
    ];
});
