<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'address', 'phone', 'email', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ledgerBooks()
    {
        return $this->hasMany(LedgerBook::class);
    }

    public function accountsHeads()
    {
        return $this->hasMany(AccountsHead::class);
    }
}