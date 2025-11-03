<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraTorta extends Model
{
    use HasFactory;

    protected $table = 'compra_torta';

    protected $fillable = [
        'compra_id',
        'torta_id',
        'tamano_id',
        'cantidad',
        'precio_unitario'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function torta()
    {
        return $this->belongsTo(Torta::class);
    }

    public function tamano()
    {
        return $this->belongsTo(Tamano::class);
    }
}
