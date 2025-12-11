<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  use HasFactory;

  // Set Primary Key Custom
  protected $primaryKey = 'banner_id';

  protected $guarded = [];

  // Relasi: Siapa yang upload banner ini?
  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by', 'id');
  }
}
