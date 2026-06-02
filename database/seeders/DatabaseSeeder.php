<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Các Seeder không có khóa ngoại
            CategorySeeder::class,
            BrandSeeder::class,
            UserSeeder::class,

            // Các Seeder có khóa ngoại
            ProductSeeder::class,
            PostSeeder::class,
        ]);

        // DB::table('users')->insert([
        //     'fullname' => 'Admin',
        //     'username' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => md5('password'),
        //     'phone' => '0123456789',
        //     'gender' => 1,
        //     'role' => 1,
        //     'status' => 1
        // ]);
    }
}
