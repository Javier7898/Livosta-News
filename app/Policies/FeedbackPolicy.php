<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Comment;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeedbackPolicy 
{

    use HandlesAuthorization;

// FeedbackPolicy.php
public function update(User $user, Feedback $feedback)
{
    return $user->id === $feedback->user_id || $user->is_admin;
}

public function delete(User $user, Feedback $feedback)
{
    return $user->id === $feedback->user_id || $user->is_admin;
}

}