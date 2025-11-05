<?php

namespace App\Http\Controllers;

use App\Models\Torta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener las 5 tortas más destacadas (las que están en el carousel)
        $tortasDestacadas = Torta::where('valoracion', '>=', 4)
            ->orderBy('valoracion', 'desc')
            ->limit(5)
            ->get();

        return view('home', ['tortasDestacadas' => $tortasDestacadas]);
    }
}
