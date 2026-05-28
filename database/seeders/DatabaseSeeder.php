<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création du compte Administrateur de Caffée Rajel Kbir
        User::create([
            'name' => 'Moez Ben Khelil',
            'email' => 'benkhelilmoez19@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '22123456',
            'address' => 'Tunis, Tunisie',
            'role' => 'admin', // Rôle admin activé !
        ]);
    }
}