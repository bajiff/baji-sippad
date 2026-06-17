<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KategoriSeeder::class,
            PelatihanSeeder::class,
        ]);

        // Create sample users
        $users = [
            ['name' => 'Siti Aminah', 'email' => 'siti@example.com', 'no_hp' => '081234567891', 'alamat' => 'Dusun Selatan, Desa Sari Mukti', 'tanggal_lahir' => '1995-03-15'],
            ['name' => 'Budi Cahyono', 'email' => 'budi@example.com', 'no_hp' => '081234567892', 'alamat' => 'Dusun Utara, Desa Sari Mukti', 'tanggal_lahir' => '1990-07-22'],
            ['name' => 'Rina Wati', 'email' => 'rina@example.com', 'no_hp' => '081234567893', 'alamat' => 'Dusun Timur, Desa Sari Mukti', 'tanggal_lahir' => '1998-11-08'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                array_merge($user, [
                    'password' => Hash::make('password'),
                    'role' => 'user',
                ])
            );
        }
    }
}
