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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Common\Model\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'first_name' => $faker->firstName,
        'middle_name' => $faker->name,
        'last_name' => $faker->lastName,
    ];
});

$factory->define(App\Common\Model\Mail::class, function (Faker\Generator $faker) {

    return [
        'sender_id' => function() {
            return factory(App\Common\Model\User::class)->create()->id;
        },
        'title' => $faker->title,
        'content' => $faker->paragraph,
        'sent_date' => date('Y-m-d')
    ];
});

$factory->define(App\Common\Model\UserMail::class, function (Faker\Generator $faker) {

    $senderId = factory(App\Common\Model\User::class)->create()->id;
    $mail = factory(App\Common\Model\Mail::class)->create();
    return [
        'sender_id' => $senderId,
        'receiver_id' => function() {
            return factory(App\Common\Model\User::class)->create()->id;
        },
        'mail_id' => $mail->id,
        'sent_date' => $mail->sent_date,
        'title' => $mail->title,
    ];
});
