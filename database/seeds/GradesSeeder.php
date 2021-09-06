<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $type = ['A','B','C','D','E','F','G','H'];

        for($i=0;$i<count($type);$i++)
        {
            DB::table('grades')->insert([
                'name' => 'VII'.$type[$i],
                'grade_level' => 7
            ]);

            DB::table('grades')->insert([
                'name' => 'VIII'.$type[$i],
                'grade_level' => 8
            ]);

            DB::table('grades')->insert([
                'name' => 'IX'.$type[$i],
                'grade_level' => 9
            ]);
        }

        DB::table('grades')->insert([
            'name' => 'VIIZ',
            'grade_level' => 7
        ]);
    }
}
