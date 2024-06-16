<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tagihan extends Model
{
    protected $table = 'tagihans'; // Sesuaikan dengan nama tabel yang Anda inginkan

    protected $fillable = [
        'user_id',
        'periode',
        'pemakaian',
        'total',
    ];

    /**
     * Define relationship to Pelanggan model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelanggan()
    {
        return $this->user->pelanggan;
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
