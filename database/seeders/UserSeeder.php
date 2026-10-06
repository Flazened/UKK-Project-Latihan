<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create supervisor user
        User::updateOrCreate(
            ['email' => 'supervisor@example.com'],
            [
                'name' => 'Bagas Benjamin',
                'password' => bcrypt(''),
                'role' => 'supervisor',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dealers@example.com'],
            [
                'name' => 'Faisal Maruf',
                'password' => bcrypt(''),
                'role' => 'dealer',
            ]
        );
    }
}
