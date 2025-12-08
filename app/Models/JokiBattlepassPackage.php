<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JokiBattlepassPackage extends Model
{
    use HasFactory;

    // Karena di database namanya 'package_id', bukan 'id'
    protected $primaryKey = 'package_id';

    protected $guarded = [];
}
