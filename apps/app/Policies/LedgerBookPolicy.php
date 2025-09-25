<?php

namespace App\Policies;

use App\Models\LedgerBook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LedgerBookPolicy
{
    public function view(User $user, LedgerBook $ledgerBook)
    {
        return $user->id === $ledgerBook->business->user_id;
    }

    public function update(User $user, LedgerBook $ledgerBook)
    {
        return $user->id === $ledgerBook->business->user_id;
    }

    public function delete(User $user, LedgerBook $ledgerBook)
    {
        return $user->id === $ledgerBook->business->user_id;
    }
}