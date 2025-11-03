<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat user pelanggan
        $customer = User::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@example.com',
            'password' => bcrypt('password'),
            'role' => 'pelanggan',
        ]);

        Pelanggan::create([
            'user_id' => $customer->id,
            'Nama_Pelanggan' => 'Pelanggan Test',
            'Email_Pelanggan' => 'pelanggan@example.com',
        ]);

        // Buat user karyawan
        $employee = User::create([
            'name' => 'Karyawan Test',
            'email' => 'karyawan@example.com',
            'password' => bcrypt('password'),
            'role' => 'karyawan',
        ]);

        Karyawan::create([
            'user_id' => $employee->id,
            'Nama_Karyawan' => 'Karyawan Test',
            'Username' => 'karyawan_test',
            'Email_Karyawan' => 'karyawan@example.com',
            'Nomor_Hp' => '081234567890'
        ]);
    }
}