<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['enc_id'];

    public function getEncIdAttribute()
    {
      return encrypt($this->id);
    }

    public function scopeActive($query){
        return $query->where('status', 1);
  }
}
