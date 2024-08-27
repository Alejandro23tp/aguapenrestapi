<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'es_periferico',
        'Mac',
        'marca',
        'modelo',
        'serie',
        'año_adquisicion',
        'precio',
        'codigo_contable',
        'direccion_ip',
        'dominio',
        'estado',
        'imagen',
    ];

}