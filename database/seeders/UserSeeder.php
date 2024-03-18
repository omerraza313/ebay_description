<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@admin.com'],[
                'name' => 'Admin',
                'role_id' => User::ADMIN_ROLE,
                'password' => bcrypt('password'),
                'status' => 'active'
        ]);
    }
}
