<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert(
            [
                'identity_number' => '11111111',
                'name' => 'Admin',
                'pob' => 'SEMARANG',
                'is_account_created' => 1
            ]
        );

        DB::table('members')->insert(
            [
                'identity_number' => '11111112',
                'name' => 'Supervisor',
                'pob' => 'SEMARANG',
                'is_account_created' => 1
            ]
        );

        DB::table('members')->insert(
            [
                'identity_number' => '11111113',
                'name' => 'Pengajar',
                'pob' => 'SEMARANG',
                'is_account_created' => 1
            ]
        );

        DB::table('members')->insert(
            [
                'identity_number' => '11111114',
                'name' => 'Siswa',
                'grade' => 'VIIZ',
                'pob' => 'SEMARANG',
                'is_account_created' => 1
            ]
        );
    }
}
