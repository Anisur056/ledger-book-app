<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class VoucherTransection extends Model
{
    use HasFactory;

    protected $fillable = [
        'ledger_book_id', 'accounts_head_id', 'transaction_type', 
        'transaction_date', 'transaction_time', 'amount', 'description',
        'voucher_number', 'reference_number'
    ];

    protected $casts = [
        'transaction_date' => 'date', // This ensures it's cast to a Carbon instance
        'amount' => 'decimal:2',
    ];

    public function ledgerBook()
    {
        return $this->belongsTo(LedgerBook::class);
    }

    public function accountsHead()
    {
        return $this->belongsTo(AccountsHead::class);
    }

    public function voucherUploads()
    {
        return $this->hasMany(VoucherUpload::class);
    }

    // Accessor to ensure transaction_date is always treated as a date
    protected function transactionDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_string($value) ? \Carbon\Carbon::parse($value) : $value,
        );
    }
}