<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GradesSeeder::class);
        $this->call(QuestionTypeSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(DemoMemberSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
