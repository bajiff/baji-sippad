<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sippad.go.id'],
            [
                'name' => 'Baji Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_superadmin' => true,
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Pusat No. 1, Jakarta',
            ]
        );
    }
}
