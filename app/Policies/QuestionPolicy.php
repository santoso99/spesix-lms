<?php

namespace App\Policies;

use App\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Question $question)
    {
        return $user->id == $question->user_id;
    }

}
