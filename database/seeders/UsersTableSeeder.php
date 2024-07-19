<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat beberapa user dummy
        $users = [
            [
                'nama' => 'SISFO AKREDITAS ADMIN',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Tambahkan data user lainnya sesuai kebutuhan
        ];

        // Masukkan data ke dalam tabel users
        DB::table('users')->insert($users);

        // Alternatif menggunakan Eloquent
        // User::insert($users);
    }
}