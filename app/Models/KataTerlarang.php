<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KataTerlarang extends Model
{
    use HasFactory;
    protected $table = 'kata_terlarang';
    protected $fillable = [
        'kata',
      ];
}
