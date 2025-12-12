<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    // INI YANG PALING PENTING! 
    // Tanpa ini, data login tidak akan terbaca (dianggap text biasa).
    protected $casts = [
        'account_credentials' => 'array', // <--- WAJIB ADA
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(JokiRankPackage::class, 'package_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
