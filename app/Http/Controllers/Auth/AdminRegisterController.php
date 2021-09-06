<?php

namespace App\Http\Controllers\Auth;

use App\Grade;
use App\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRegisterFormRequest;
use Spatie\Permission\Models\Role;

class AdminRegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register-admin');
    }

    public function store(AdminRegisterFormRequest $request)
    {
        $validated = $request->validated();

        $member = Member::create([
            'identity_number' => $validated['identity_number'],
            'name' => $validated['name'],
            'pob' => '-',
            'is_account_created' => 1,
        ]);

        $member->user()->create([
            'name' => $member->name,
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])->assignRole(4);

        return $this->authenticate($request->only('email','password'));
    }

    public function authenticate($credentials)
    {
        if(Auth::attempt($credentials)){
            return redirect('/dashboard');
        }

        return back();
    }
}
