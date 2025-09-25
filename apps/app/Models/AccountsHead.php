<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsHead extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'code', 'name', 'type', 'description', 'is_active'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function voucherTransections()
    {
        return $this->hasMany(VoucherTransection::class);
    }
}