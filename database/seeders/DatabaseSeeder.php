<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Operator',
            'Mahasiswa',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'role' => 'Super Admin',
            ],
            [
                'name' => 'Operator',
                'email' => 'operator@example.com',
                'role' => 'Operator',
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@example.com',
                'role' => 'Mahasiswa',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ],
            );

            $user->syncRoles($userData['role']);
        }
    }
}
