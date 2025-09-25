<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BusinessPolicy
{
    public function view(User $user, Business $business)
    {
        return $user->id === $business->user_id;
    }

    public function update(User $user, Business $business)
    {
        return $user->id === $business->user_id;
    }

    public function delete(User $user, Business $business)
    {
        return $user->id === $business->user_id;
    }
}