<?php

namespace App\Observers;

use App\Member;
use App\Traits\HandleImageTrait;

class SchoolMemberObserver
{
    use HandleImageTrait;
    /**
     * Handle the member "created" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function created(Member $member)
    {
        //
    }

    /**
     * Handle the member "updated" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function updated(Member $member)
    {
        //
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function deleting(Member $member)
    {
        $this->deleteImage(public_path('storage/').$member->user->avatar);
        $member->user()->delete();
    }

    /**
     * Handle the member "restored" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function restored(Member $member)
    {
        //
    }

    /**
     * Handle the member "force deleted" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function forceDeleted(Member $member)
    {
        //
    }
}
