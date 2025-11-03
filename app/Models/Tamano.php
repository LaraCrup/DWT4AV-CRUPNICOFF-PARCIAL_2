<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamano extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function tortas()
    {
        return $this->belongsToMany(Torta::class, 'torta_tamano')
                    ->withPivot('precio')
                    ->withTimestamps();
    }
}
