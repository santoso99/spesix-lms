<?php

namespace App\Http\Controllers\Member;

use App\User;
use App\Member;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberImportRequest;
use Illuminate\Http\Request;
use App\Imports\MemberImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class MemberController extends Controller
{
    public function index()
    {
        $members = Cache::remember('members', config('cache.duration.long'), function(){
            return Member::all();
        });
        
        return view('admin.member.index', compact('members'));
    }

    public function create()
    {
        return view('admin.member.create');
    }

    public function import(MemberImportRequest $request)
    {
        Excel::import(new MemberImport, $request->file('member_file'));
        
        return redirect('admin/members')->with('status', __('messages.member_data_imported'));
    }

    public function destroy(Request $request)
    {
        $member_ids = $request->member_id;

        if($member_ids == null){
            return back();
        }

        $users = User::whereIn('member_id',$member_ids)->select('avatar')->get();
        foreach($users as $user)
        {
            $this->deleteImage(public_path('storage/'.$user->avatar));
        }

        User::whereIn('member_id', $member_ids)->delete();
        Member::whereIn('id', $member_ids)->delete();

        Cache::forget('members');

        return redirect('admin/members')->with('status', __('messages.member_data_deleted'));
    }
}
