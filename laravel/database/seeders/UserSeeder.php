<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Candy',
            'email'    => 'epicboyny@gmail.com',
            'password' => Hash::make('cheacms07'),
        ]);

        $user->assignRole('admin');
    }
}
