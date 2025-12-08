<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id'; // Kasih tau Laravel ini PK-nya
    protected $guarded = [];

    // Relasi User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
