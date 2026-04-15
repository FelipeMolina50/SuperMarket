<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Revisar si ya existe
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Super Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'super_admin',
                'status' => 'approved',
            ]);
        }
    }
}
