<?php

namespace App\Http\Controllers\User;

use App\Grade;
use App\User;
use App\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdminInputRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\StoreUserTrait;
use App\Traits\HandleImageTrait;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use StoreUserTrait, HandleImageTrait;

    public function index()
    {
        $users = User::with(['member'])
                    ->whereNull('student_id')
                    ->where('id','<>',Auth::user()->id)
                    ->select('id','member_id','name','email')
                    ->get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserAdminInputRequest $request)
    {
        $request = $this->addRequestValue($request);
        $member = Member::create($request->only('identity_number','name','grade','pob','is_account_created'));
        $request->request->add(['member_id' => $member->id]);
        $user = User::create($request->only('grade_id','member_id','name','email','password'));
        $user->assignRole($request->validated()['role']);

        return redirect('admin/users')->with('status', __('messages.account_data_created'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(UserAdminInputRequest $request, User $user)
    {
        $request = $this->addRequestValue($request);
        
        $member = Member::findOrFail($user->member_id);
        $member->update($request->only('identity_number','name','grade','pob','is_account_created'));
        $user->update($request->only('grade_id','name','email','password'));
        $role_id = Role::where('name',$request->validated()['role'])->first()->id;
        DB::table('model_has_roles')->where('model_id',$user->id)->update(['role_id' => $role_id]);

        return redirect('admin/users')->with('status', __('messages.account_data_updated'));
    }
}
