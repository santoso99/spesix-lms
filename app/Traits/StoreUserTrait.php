<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Requests\UserAdminInputRequest;
use App\Grade;

trait StoreUserTrait{
    
    public function addRequestValue(UserAdminInputRequest $request)
    {
        $grade_name = Grade::where('id',$request->grade_id)->pluck('name')->first();
        $grade = empty($grade_name) ? null : $grade_name;

        $request->request->add([
            'grade' => $grade,
            'is_account_created' => 1,
        ]);

        return $request;
    }

}