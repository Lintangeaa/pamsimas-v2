<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'no_pelanggan',
        'alamat_pelanggan'
    ];




    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
