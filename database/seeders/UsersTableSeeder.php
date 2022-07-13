<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // FIXME: Remove this after the presentation
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@stackunderflow.tk',
            'email_verified_at' => now(),
            'biography' => 'StackUnderflow default admin account',
            'company' => '@stackunderflow',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'admin' => true
        ]);

        User::factory()->count(500)->create();
    }
}
