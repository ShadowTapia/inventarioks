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

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2, $role3]);
        Permission::create(['name' => 'usuarios'])->assignRole($role1);
        Permission::create(['name' => 'user.create'])->assignRole($role1);
        Permission::create(['name' => 'user.edit'])->assignRole($role1);
        Permission::create(['name' => 'user.destroy'])->assignRole($role1);
    }
}
