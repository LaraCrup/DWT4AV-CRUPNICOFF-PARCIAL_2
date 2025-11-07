<?php

namespace App\Http\Controllers;

use App\Models\Torta;

class HomeController extends Controller
{
    public function index()
    {
        $tortasDestacadas = Torta::where('destacada', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', ['tortasDestacadas' => $tortasDestacadas]);
    }
}
