<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lygstylesize extends Model
{
    use HasFactory;
    protected $table = 'lygstylesize';
    // protected $primaryKey = 'styleCode';
    // protected $keyType = 'string';
    protected $fillable = [
        'styleCode',
        'sizeSort',
        'sizeName',
    ];
}
