<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'horario',
        'activo',
        'mac',
        'rol_id',
        'empresa_id',
        'fecha_ini',
        'fecha_fin',
        'horas_extra',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_ini' => 'date',
        'fecha_fin' => 'date',
        'horas_extra' => 'decimal:2',
    ];

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function practicas(): HasMany
    {
        return $this->hasMany(Practica::class, 'usuario_id');
    }

    public function incidencias(): HasMany
    {
        return $this->hasMany(Incidencia::class, 'id_usuario');
    }

    public function fichajes(): HasMany
    {
        return $this->hasMany(Fichaje::class, 'id_usuario');
    }
}
