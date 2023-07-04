<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('users')->insert([
           'name' => 'admin',
           'email' => 'webmaster@localhost.localdomain',
           'password' => bcrypt('P@ssw0rd#2023'),
       ]);
    }
}
