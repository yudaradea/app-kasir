<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Administrator',
                'email' => 'yudaradea@gmail.com',
                'level' => 1,
                'password' => static::$password ??= Hash::make('yudaaradea'),
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@gmail.com',
                'level' => 0,
                'password' => static::$password ??= Hash::make('yudaaradea'),
            ]
        ]);
    }
}
