<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'mahasiswa.view',
            'mahasiswa.create',
            'mahasiswa.edit',
            'mahasiswa.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'Staf', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);
        $staffRole->syncPermissions(['dashboard.view', 'mahasiswa.view']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@kampus.test'],
            [
                'name' => 'Administrator Akademik',
                'password' => Hash::make('Admin123!'),
            ]
        );
        $admin->forceFill(['email_verified_at' => now()])->save();
        $admin->syncRoles([$adminRole]);

        $staff = User::updateOrCreate(
            ['email' => 'staf@kampus.test'],
            [
                'name' => 'Staf Akademik',
                'password' => Hash::make('Staf123!'),
            ]
        );
        $staff->forceFill(['email_verified_at' => now()])->save();
        $staff->syncRoles([$staffRole]);

        $faker = \Faker\Factory::create('id_ID');
        $programs = ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Manajemen'];

        for ($number = 1; $number <= 50; $number++) {
            Student::updateOrCreate(
                ['nim' => '2026' . str_pad((string) $number, 6, '0', STR_PAD_LEFT)],
                [
                    'name' => $faker->name(),
                    'study_program' => $faker->randomElement($programs),
                    'email' => 'mhs' . $number . '@kampus.test',
                    'status' => $faker->randomElement(['Aktif', 'Aktif', 'Aktif', 'Cuti', 'Lulus']),
                ]
            );
        }
    }
}
