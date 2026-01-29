<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fichaje extends Model
{
    use HasFactory;

    protected $table = 'fichaje';

    protected $fillable = [
        'id_usuario',
        'fecha',
        'fecha_original',
        'hora_entrada',
        'hora_salida',
        'estado',
        'justificado',
        'justificacion',
        'justificacion_foto',
        'justificacion_estado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_original' => 'date',
        'justificado' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
