<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes,MustVerifyEmailTrait;


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
    'veces_registradas',
    'faltas_justificadas',
    'faltas_sin_justificar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_ini' => 'date',
        'fecha_fin' => 'date',
        'horas_extra' => 'decimal:2',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'veces_registradas' => 'integer',
        'faltas_justificadas' => 'integer',
        'faltas_sin_justificar' => 'integer',
    ];

    public function isAdmin(): bool
    {
        return $this->rol && $this->rol->nombre === 'Administrador';
    }

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
