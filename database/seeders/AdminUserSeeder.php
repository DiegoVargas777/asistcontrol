<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $employed = Role::firstOrCreate(['name' => 'empleado']);
        Permission::firstOrCreate(['name' => 'crear usuario']);
        Permission::firstOrCreate(['name' => 'editar usuario']);
        Permission::firstOrCreate(['name' => 'borrar usuario']);

        $admin->givePermissionTo(['crear usuario', 'editar usuario', 'borrar usuario']);

        // Crear usuario admin
        $user = User::firstOrCreate(
            ['email' => 'admin@asistcontrol.cl'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin'),
            ]
        );

        $user->assignRole($admin);
    }
}
