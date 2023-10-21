<?php

namespace Database\Seeders;

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
        //Roles
        Permission::create(['name' => 'roles', 'description' => 'Lista de Roles'])->assignRole($role1);
        Permission::create(['name' => 'rol.create', 'description' => 'Creación de Roles'])->assignRole($role1);
        Permission::create(['name' => 'rol.edit', 'description' => 'Edición de Roles'])->assignRole($role1);
        //Departamentos
        Permission::create(['name' => 'departamentos', 'description' => 'Lista de Departamentos'])->assignRole($role1);
        Permission::create(['name' => 'depa.create', 'description' => 'Creación de Departamentos'])->assignRole($role1);
        Permission::create(['name' => 'depa.edit', 'description' => 'Edición de Departamentos'])->assignRole($role1);
        Permission::create(['name' => 'depa.destroy', 'description' => 'Eliminación de Departamentos'])->assignRole($role1);
        //Proveedores
        Permission::create(['name' => 'suppliers', 'description' => 'Listado de Proveedores'])->assignRole($role1);
        Permission::create(['name' => 'supp.create', 'description' => 'Creación de Proveedores'])->assignRole($role1);
        Permission::create(['name' => 'supp.edit', 'description' => 'Edición de Proveedores'])->assignRole($role1);
        Permission::create(['name' => 'supp.destroy', 'description' => 'Eliminación de Proveedores'])->assignRole($role1);
        //Companies
        Permission::create(['name' => 'companies', 'description' => 'Listado de compañias'])->assignRole($role1);
        Permission::create(['name' => 'comp.create', 'description' => 'Creación de compañias'])->assignRole($role1);
        Permission::create(['name' => 'comp.edit', 'description' => 'Edición de Compañías'])->assignRole($role1);
        Permission::create(['name' => 'comp.destroy', 'description' => 'Eliminación de Compañías'])->assignRole($role1);
    }
}
