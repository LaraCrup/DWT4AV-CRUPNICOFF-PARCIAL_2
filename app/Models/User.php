<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'rol_id',
        'name',
        'email',
        'password',
        'fecha_nacimiento',
        'fecha_registro'
    ];

    protected $hidden = [
        'password',
    ];


    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    public function compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'usuario_id');
    }
}
