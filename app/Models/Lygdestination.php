<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lygdestination extends Model
{
    use HasFactory;
    protected $table = 'lygdestination';
    // protected $primaryKey = 'destinationCode';
    // protected $keyType = 'string';
    protected $fillable = [
        'destinationCode',
        'destinationName'
    ];
}
