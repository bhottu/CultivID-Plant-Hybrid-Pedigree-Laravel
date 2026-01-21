<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Bot1',
            'username' => 'systembot1',        // jika ada field username
            'email' => 'bot@cultiv.id',
            'password' => Hash::make('testtest'),
            'is_admin' => 1,                   // jika ada kolom admin
        ]);
    }
}
