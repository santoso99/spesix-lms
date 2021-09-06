<?php

namespace App\Imports;

use App\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MemberImport implements ToModel
{

    public function model(array $row)
    {
        return new Member([
            'identity_number' => $row[0],
            'name' => $row[1],
            'grade' => $row[2],
            'pob' => strtoupper($row[3]),
        ]);
    }
}
