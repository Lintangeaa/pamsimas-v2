<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user admin
        User::factory()->create([
            'username' => 'admin1',
            'role' => 'admin'
        ]);

        // Buat user pelanggan
        // $pelangganUser = User::create([
        //     'id' => Uuid::uuid4()->toString(),
        //     'name' => 'Test Pelanggan',
        //     'email' => 'pelanggan@gmail.com',
        //     'role' => 'pelanggan',
        //     'password' => Hash::make('password')
        // ]);

        // // Buat data pelanggan yang terkait dengan user tersebut
        // Pelanggan::create([
        //     'user_id' => $pelangganUser->id,
        //     'nama_pelanggan' => 'Pelanggan A',
        //     'no_pelanggan' => 'PLG001',
        //     'alamat_pelanggan' => 'Alamat Pelanggan A',
        // ]);
    }
}
