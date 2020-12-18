<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'name'     => 'Alpesh Lalakiya',
            'username' => 'alpesh',
            'email'    => 'alpesh@gmail.com',
            'password' => Hash::make('password'),
        ));
    }
}