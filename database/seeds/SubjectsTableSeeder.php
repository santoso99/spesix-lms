<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            ['name' => 'Pendidikan Agama  dan Budi Pekerti'],
            ['name' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['name' => 'Bahasa Indonesia '],
            ['name' => 'Matematika'],
            ['name' => 'Sejarah Indonesia'],
            ['name' => 'Bahasa Inggris'],
            ['name' => 'Seni Budaya'],
            ['name' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['name' => 'Prakarya dan Kewirausahaan'],
            ['name' => 'Bahasa Jawa'],
            ['name' => 'Informatika'],
            ['name' => 'Bimbingan Konseling'],
            ['name' => 'Matematika'],
            ['name' => 'Biologi'],
            ['name' => 'Fisika'],
            ['name' => 'Kimia'],
            ['name' => 'Bahasa dan Sastra Inggris'],
        ]);
    }
}
