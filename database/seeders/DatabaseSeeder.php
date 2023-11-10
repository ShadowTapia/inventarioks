<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Storage::deleteDirectory('public/products'); //Con esto nos aseguramos de eliminar el directorio antes de su creación
        Storage::makeDirectory('public/products'); //Crea la carpeta donde se almacenaran las imagenes

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        \App\Models\department::factory(5)->create();
        \App\Models\supplier::factory(5)->create();
        \App\Models\company::factory(5)->create();
        \App\Models\productype::factory(10)->create();
        $this->call(ProductSeeder::class);
        \App\Models\devices::factory(20)->create();
        \App\Models\activity::factory(20)->create();
        \App\Models\image::factory(10)->create();
    }
}
