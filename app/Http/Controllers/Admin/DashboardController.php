<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos de ejemplo para el dashboard
        // Aquí puedes reemplazar con datos reales de la base de datos
        
        $data = [
            'salesTodayAmount' => '$15,240',
            'salesWeeklyAverage' => '$12,450',
            'topUsers' => [
                ['name' => 'Ana García', 'amount' => '$5,320'],
                ['name' => 'Martín López', 'amount' => '$4,780'],
                ['name' => 'Carolina Méndez', 'amount' => '$3,950'],
                ['name' => 'Pablo Rodríguez', 'amount' => '$3,210'],
                ['name' => 'Valentina Torres', 'amount' => '$2,890'],
                ['name' => 'Luciano Pereyra', 'amount' => '$2,650'],
                ['name' => 'Florencia Gómez', 'amount' => '$2,480'],
                ['name' => 'Sebastián Ortiz', 'amount' => '$2,320'],
                ['name' => 'Camila Fernández', 'amount' => '$2,150'],
                ['name' => 'Nicolás Ramírez', 'amount' => '$1,980'],
            ],
            'topProducts' => [
                ['name' => 'Torta de Chocolate', 'sales' => '342 unidades', 'image' => '../images/products/chocolate.webp'],
                ['name' => 'Cheesecake Frutos Rojos', 'sales' => '287 unidades', 'image' => '../images/products/cheesecake.webp'],
                ['name' => 'Chocotorta', 'sales' => '213 unidades', 'image' => '../images/products/chocotorta.webp'],
                ['name' => 'Red Velvet', 'sales' => '185 unidades', 'image' => '../images/products/red-velvet.webp'],
            ],
            'monthlyRevenue' => '$87,540',
            'monthlyOrders' => '423',
            'newCustomers' => '89',
        ];

        return view('admin.dashboard', $data);
    }
}
