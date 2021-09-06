<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserAvatarRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\HandleImageTrait;

class UserAvatarController extends Controller
{
    use HandleImageTrait;

    public function edit()
    {
        return view('admin.user.avatar-edit');
    }

    public function update(UserAvatarRequest $request)
    {
        $old_avatarPath = public_path('storage/'.Auth::user()->avatar);
        $this->deleteImage($old_avatarPath);

        $avatarFile = $request->validated()['avatar'];
        Auth::user()->update([
            'avatar' => $avatarFile->store('uploads/avatar','public'),
        ]);
        
        $new_avatarPath = public_path('storage/'.Auth::user()->avatar);
        $this->resizeImage($new_avatarPath, 200);
        
        return back()->with('status',__('messages.avatar_changed'));
    }

    public function reset(User $user)
    {
        $this->deleteImage(public_path('storage/'.Auth::user()->avatar));
        $user->update(['avatar' => null]);
    }
}
