<?php

namespace App\Policies;

use App\Models\AccountsHead;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccountsHeadPolicy
{
    public function view(User $user, AccountsHead $accountsHead)
    {
        return $user->id === $accountsHead->business->user_id;
    }

    public function update(User $user, AccountsHead $accountsHead)
    {
        return $user->id === $accountsHead->business->user_id;
    }

    public function delete(User $user, AccountsHead $accountsHead)
    {
        return $user->id === $accountsHead->business->user_id;
    }
}