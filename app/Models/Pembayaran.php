<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'tagihan_id',
        'total_pembayaran',
        'status',
        'snap_token'
    ];
}
