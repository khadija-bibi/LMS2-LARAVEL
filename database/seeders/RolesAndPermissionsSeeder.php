<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Pehle Cache Clear Karo
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::query()->delete();
        Permission::query()->delete();

        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        $permissions = [
            // **Students**
            'create student', 'edit student', 'delete student', 'view student',

            // **Teachers**
            'create teacher', 'edit teacher', 'delete teacher', 'view teacher',

            // **Courses**
            'create course', 'edit course', 'delete course', 'view course',

            // **Content**
            'create content', 'delete content', 'view content',

            // **Assignments**
            'create assignment', 'edit assignment', 'delete assignment', 'view assignment',

            // **Assignment Submissions**
            'create submission', 'delete submission', 'view submission',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo([
            'create student', 'edit student', 'delete student', 'view student',
            'create teacher', 'edit teacher', 'delete teacher', 'view teacher',
            'create course', 'edit course', 'delete course', 'view course',
            'create content', 'delete content', 'view content',
            'create assignment', 'edit assignment', 'delete assignment', 'view assignment',
            'create submission', 'delete submission', 'view submission',
        ]);

        $teacherRole->givePermissionTo([
            'create content', 'delete content', 'view content',
            'create assignment', 'edit assignment', 'delete assignment', 'view assignment',
            'view student',
            'create submission', 'delete submission', 'view submission',
        ]);

        $studentRole->givePermissionTo([
            'view course',
            'view content',
            'view assignment',
            'create submission', 'delete submission', 'view submission',
        ]);

        $this->command->info('Roles and permissions assigned successfully!');
    }
}
