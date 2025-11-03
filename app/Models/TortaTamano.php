<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TortaTamano extends Model
{
    use HasFactory;

    protected $table = 'torta_tamano';

    protected $fillable = ['torta_id', 'tamano_id', 'precio'];

    public function torta()
    {
        return $this->belongsTo(Torta::class);
    }

    public function tamano()
    {
        return $this->belongsTo(Tamano::class);
    }
}
