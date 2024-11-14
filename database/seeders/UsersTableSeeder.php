<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure to import the User model

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin user
        User::create([
            'name' => 'Admin User', // You can customize the name
            'email' => 'admin@dndsoftware.in',
            'password' => Hash::make('Dnd@6080'), // Hash the password
        ]);
    }
}
