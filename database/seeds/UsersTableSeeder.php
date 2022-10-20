<?php

use App\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'id'             => 1,
            'name'           => 'Admin',
            'email'          => 'admin@admin.com',
            'password'       => '$2y$10$Y.jEitizf.DW3V7gxCnMr.SdWN2i1w4gobo28vTLGaFajqcjUl8Oy',
            'remember_token' => null,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

        User::create([
            'id'             => 2,
            'name'           => 'User',
            'email'          => 'user@user.com',
            'password'       => '$2y$10$Y.jEitizf.DW3V7gxCnMr.SdWN2i1w4gobo28vTLGaFajqcjUl8Oy',
            'remember_token' => null,
            'created_at'     => Carbon::now(),
            'updated_at'     => Carbon::now(),
        ]);

    }
}
