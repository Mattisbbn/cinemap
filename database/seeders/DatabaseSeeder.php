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
        User::query()->firstOrCreate(['email' => 'example@gmail.com'], [
            'name' => 'Admin',
            'email' => 'example@gmail.com',
            'password' => Hash::make('49610'),
            'is_admin' => true,
        ]);

        User::query()->firstOrCreate(['email' => 'mcp@mcpuser.com'], [
            'name' => 'MCPuser',
            'email' => 'mcp@mcpuser.com',
            'password' => Hash::make('94951591'),
            'is_admin' => false,
            'id' => 999,
        ]);
    }
}
