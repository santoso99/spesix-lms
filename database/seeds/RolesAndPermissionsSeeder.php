<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        Role::create(['name'=>'Siswa']);
        Role::create(['name'=>'Pengajar']);
        Role::create(['name'=>'Supervisor']);
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'Wali Siswa']);

        $admin_tu = factory(\App\User::class)->create([
            'member_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@spesix-lms.com',
            'password' => '12345678'
        ]);
        $admin_tu->assignRole('Admin');

        $supervisor = factory(\App\User::class)->create([
            'member_id' => 2,
            'name' => 'Supervisor',
            'email' => 'supervisor@spesix-lms.com',
            'password' => '12345678'
        ]);
        $supervisor->assignRole('Supervisor');

        $teacher = factory(\App\User::class)->create([
            'member_id' => 3,
            'name' => 'Pengajar',
            'email' => 'teacher@spesix-lms.com',
            'password' => '12345678'
        ]);
        $teacher->assignRole('Pengajar');

        $student = factory(\App\User::class)->create([
            'grade_id' => 25,
            'member_id' => 4,
            'name' => 'Siswa',
            'email' => 'student@spesix-lms.com',
            'password' => '12345678'
        ]);
        $student->assignRole('Siswa');

        $parent = factory(\App\User::class)->create([
            'student_id' => 4,
            'name' => 'Wali Siswa',
            'email' => 'parent@spesix-lms.com',
            'password' => '12345678'
        ]);
        $parent->assignRole('Wali Siswa');

    }
}
