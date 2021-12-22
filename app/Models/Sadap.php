<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sadap extends Model
{
    use HasFactory;
    protected $table = 'sadap';
    protected $fillable = [
        'id',
        'ip',
        'ua',
      ];
}
