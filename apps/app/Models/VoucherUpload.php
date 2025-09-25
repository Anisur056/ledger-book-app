<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_transection_id', 'file_path', 'file_name', 
        'original_name', 'mime_type', 'file_size'
    ];

    public function voucherTransection()
    {
        return $this->belongsTo(VoucherTransection::class);
    }
}