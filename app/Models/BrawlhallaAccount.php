<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrawlhallaAccount extends Model
{
    use HasFactory;

    // Karena di database namanya 'account_id'
    protected $primaryKey = 'account_id';

    protected $guarded = [];

    protected $casts = [
        'image_url' => 'array', // Wajib! Biar otomatis jadi array saat diambil
    ];

    // Relasi: Akun ini dijual oleh siapa?
    public function seller()
    {
        // Kita arahkan ke 'id' (Primary Key standar tabel users)
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
