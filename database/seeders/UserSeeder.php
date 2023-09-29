<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Marcelo Tapia',
            'email' => 'mftapia72@gmail.com',
            'password' => Hash::make('12345678')
        ])->assignRole('Admin');

        User::factory(15)->create();
    }
}
