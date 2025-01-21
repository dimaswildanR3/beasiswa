<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'  => 'Administrator',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password'  => bcrypt('admin')
        ]);
        \App\User::create([
            'name'  => 'Perpus',
            'email' => 'perpus1@gmail.com',
            'role' => 'PetugasPerpus',
            'password'  => bcrypt('perpus1')
        ]);
    }
}
