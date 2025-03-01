<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // List of permissions
        $permissions = [
            'view users',
            'show users',
            'create users',
            'update users',
            'delete users',
            'view roles',
            'show roles',
            'create roles',
            'assign roles',
            'update roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
        ];

        // Buat permission hanya jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Ambil semua permissions sekali saja
        $allPermissions = Permission::all();

        // Create roles and assign permissions
        $rolesPermissions = [
            'Superadmin' => $allPermissions, // Assign semua permission ke Superadmin
            'Admin' => ['view users', 'show users'],
        ];

        foreach ($rolesPermissions as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Data Users
        $users = [
            [
                'name' => 'Super',
                'username' => 'superadmin',
                'last_name' => 'Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ],
        ];

        // Buat user dan assign role
        foreach ($users as $userData) {
            $roleName = $userData['role']; // Simpan role sebelum membuat user
            unset($userData['role']); // Hapus role dari data user agar tidak menyebabkan error
            $user = User::firstOrCreate(['email' => $userData['email']], $userData);
            $user->assignRole($roleName);
        }
    }
}
