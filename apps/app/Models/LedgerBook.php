<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LedgerBook extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'name', 'financial_year', 'start_date', 'end_date', 'description', 'is_active'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function voucherTransections()
    {
        return $this->hasMany(VoucherTransection::class);
    }

    // Accessors to ensure dates are always treated as Carbon instances
    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_string($value) ? \Carbon\Carbon::parse($value) : $value,
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_string($value) ? \Carbon\Carbon::parse($value) : $value,
        );
    }
}