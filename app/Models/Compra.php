<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'fecha_compra', 'total'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }


    public function tortas()
    {
        return $this->belongsToMany(Torta::class, 'compra_torta')
            ->withPivot('tamano_id', 'cantidad', 'precio_unitario')
            ->withTimestamps();
    }
}
