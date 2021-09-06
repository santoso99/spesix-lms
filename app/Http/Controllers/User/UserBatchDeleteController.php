<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\HandleImageTrait;

class UserBatchDeleteController extends Controller
{
    use HandleImageTrait;

    public function __invoke(Request $request)
    {
        $user_ids = $request->user_id;
        $member_ids = [];

        if($user_ids == null){
            return back();
        }

        DB::table('model_has_roles')->whereIn('model_id',$user_ids)->delete();
        
        $users = User::whereIn('id',$user_ids)->select('avatar','member_id')->get();
        foreach($users as $user)
        {
            $this->deleteImage(public_path('storage/'.$user->avatar));
            array_push($member_ids, $user->member_id);
        }

        Member::whereIn('id', $member_ids)->update(['is_account_created' => 0]);
        User::whereIn('id', $user_ids)->delete();
        return back()->with('status', __('messages.account_data_deleted'));
    }
}
