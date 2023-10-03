<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Usuario']);
        $role3 = Role::create(['name' => 'Lector']);

        Permission::create(['name' => 'dashboard', 'description' => 'Ver Dashboard'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'usuarios', 'description' => 'Lista de Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'user.create', 'description' => 'Crear Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'user.edit', 'description' => 'Editar Usuarios'])->assignRole($role1);
        Permission::create(['name' => 'user.destroy', 'description' => 'Eliminar Usuarios'])->assignRole($role1);
    }
}
