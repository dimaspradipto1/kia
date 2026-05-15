<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nama_role' => 'administrator',
                'deskripsi' => 'Administrator Sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'dinas kesehatan',
                'deskripsi' => 'Dinas Kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'nakes',
                'deskripsi' => 'Tenaga Kesehatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_role' => 'ibu hamil',
                'deskripsi' => 'Ibu Hamil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
