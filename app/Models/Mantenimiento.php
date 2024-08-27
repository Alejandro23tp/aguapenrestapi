<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'fecha_ingreso',
        'fecha_salida',
        'observacion'
    ];
}
