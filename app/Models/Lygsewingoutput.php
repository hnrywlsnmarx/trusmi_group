<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lygsewingoutput extends Model
{
    use HasFactory;
    protected $table = 'lygsewingoutput';
    protected $fillable = [
        'trnDate',
        'operatorName',
        'styleCode',
        'sizeName',
        'destinationCode',
        'QtyOutput'
    ];
}
