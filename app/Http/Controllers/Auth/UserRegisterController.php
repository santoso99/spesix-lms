<?php

namespace App\Http\Controllers\Auth;

use App\Grade;
use App\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegistrationRequest;
use Spatie\Permission\Models\Role;

class UserRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function store(UserRegistrationRequest $request)
    {
        $validated = $request->validated();
        $member = Member::whereIdentityNumber($validated['identity_number'])->first();

        if($member->is_account_created == 1)
        {
            return back()->withInput()->with('unavailable',__('messages.account_with_identity_no').$validated['identity_number'].__('messages.already_registered'));
        }
        // else if($member->pob != strtoupper($validated['pob']))
        // {
        //     return back()->withInput()->with('pob_unverified', __('messaegs.pob_not_verified'));
        // }
        
        if($member->grade == null)
        {
            $role_id = 2;
            $grade_id = null;
        }
        else {
            $role_id = 1;
            $grade_id = Grade::whereName($member->grade)->pluck('id')->first();
        }

        $user = User::create([
            'grade_id' => $grade_id,
            'member_id' => $member->id,
            'name' => $member->name,
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->assignRole($role_id);

        $member->is_account_created = 1;
        $member->save();

        return $this->authenticate($request->only('email','password'));
    }

    private function authenticate($credentials)
    {
        if(Auth::attempt($credentials)){
            return redirect('/dashboard');
        }

        return back();
    }
}
