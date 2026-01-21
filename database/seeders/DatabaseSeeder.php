<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
           'name' => 'Bot1',
            'username' => 'systembot',        // jika ada field username
            'email' => 'bot@cultiv.id',
            'password' => Hash::make('testtest'),
            'is_admin' => 1,             // jika ada kolom admin
        ]);
    }
}


