<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torta extends Model
{
    use HasFactory;

    protected $table = 'tortas';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'imagen',
        'valoracion',
        'alergeno',
        'descripcion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tamanos()
    {
        return $this->belongsToMany(Tamano::class, 'torta_tamano')
                    ->withPivot('precio')
                    ->withTimestamps();
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_torta')
                    ->withPivot('tamano_id', 'cantidad', 'precio_unitario')
                    ->withTimestamps();
    }
}
