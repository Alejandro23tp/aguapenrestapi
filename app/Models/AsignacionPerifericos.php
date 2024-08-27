<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AsignacionPerifericos extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'equipo_principal_id',
        'periferico_id'
    ];

    public function equipoPrincipal()
    {
        return $this->belongsTo(Equipos::class, 'equipo_principal_id');
    }

    public function periferico()
    {
        return $this->belongsTo(Equipos::class, 'periferico_id');
    }

    /**
     * Método para asignar un periférico a un equipo principal.
     */
    public function asignarPeriferico(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:asignacion_perifericos,codigo',
            'equipo_principal_id' => 'required|exists:equipos,id',
            'periferico_id' => 'required|exists:equipos,id',
        ]);

        $datacreate = self::create($data);
        return response()->json([
            'mensaje' => 'Creación de asignación de periférico',
            'data' => $datacreate,
        ]);
    }
}