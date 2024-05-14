<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::create([
            'name' => 'Admin',
            'description' => 'This user type has all the permissions',
        ]);

        UserType::create([
            'name' => 'Developer',
            'description' => 'This user type has all the permissions',
        ]);

        UserType::create([
            'name' => 'User',
            'description' => 'This user type has limited permissions',
        ]);
    }
}
