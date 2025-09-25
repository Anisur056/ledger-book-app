<?php

namespace App\Policies;

use App\Models\VoucherTransection;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VoucherTransectionPolicy
{
    public function view(User $user, VoucherTransection $voucherTransection)
    {
        return $user->id === $voucherTransection->ledgerBook->business->user_id;
    }

    public function update(User $user, VoucherTransection $voucherTransection)
    {
        return $user->id === $voucherTransection->ledgerBook->business->user_id;
    }

    public function delete(User $user, VoucherTransection $voucherTransection)
    {
        return $user->id === $voucherTransection->ledgerBook->business->user_id;
    }
}