<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Torta;
use App\Models\Compra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $topUsers = User::select('users.id', 'users.name')
            ->selectRaw('SUM(compras.total) as total_spent')
            ->join('compras', 'users.id', '=', 'compras.usuario_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get()
            ->map(fn($user) => [
                'name' => $user->name,
                'amount' => '$' . number_format($user->total_spent, 2, ',', '.')
            ]);

        $topProducts = Torta::select('tortas.id', 'tortas.nombre', 'tortas.imagen')
            ->selectRaw('SUM(compra_torta.cantidad) as total_quantity')
            ->join('compra_torta', 'tortas.id', '=', 'compra_torta.torta_id')
            ->groupBy('tortas.id', 'tortas.nombre', 'tortas.imagen')
            ->orderByDesc('total_quantity')
            ->limit(4)
            ->get()
            ->map(fn($torta) => [
                'name' => $torta->nombre,
                'sales' => $torta->total_quantity . ' unidades',
                'image' => $torta->imagen ? '/storage/products/' . $torta->imagen : '/storage/products/chocolate.webp'
            ]);

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyRevenue = Compra::whereBetween('fecha_compra', [$startOfMonth, $endOfMonth])
            ->sum('total');

        $monthlyOrders = Compra::whereBetween('fecha_compra', [$startOfMonth, $endOfMonth])
            ->count();

        $newCustomers = User::whereBetween('fecha_registro', [$startOfMonth, $endOfMonth])
            ->count();

        $dailySales = Compra::selectRaw('DATE(fecha_compra) as fecha, SUM(total) as total')
            ->whereBetween('fecha_compra', [$startOfMonth, $endOfMonth])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get()
            ->map(fn($sale) => [
                'fecha' => Carbon::parse($sale->fecha)->format('d/m'),
                'total' => (float) $sale->total
            ]);

        $salesToday = Compra::whereDate('fecha_compra', Carbon::today())->sum('total');

        $sevenDaysAgo = Carbon::now()->subDays(7);
        $totalLastSevenDays = Compra::whereBetween('fecha_compra', [$sevenDaysAgo, Carbon::now()])->sum('total');
        $daysWithSalesLastWeek = Compra::whereBetween('fecha_compra', [$sevenDaysAgo, Carbon::now()])
            ->selectRaw('COUNT(DISTINCT DATE(fecha_compra)) as count')
            ->first()
            ->count ?? 1;
        $weeklyAverage = $daysWithSalesLastWeek > 0 ? $totalLastSevenDays / $daysWithSalesLastWeek : 0;

        $data = [
            'salesTodayAmount' => '$' . number_format($salesToday, 2, ',', '.'),
            'salesWeeklyAverage' => '$' . number_format($weeklyAverage, 2, ',', '.'),
            'dailySalesJson' => json_encode($dailySales),
            'topUsers' => $topUsers,
            'topProducts' => $topProducts,
            'monthlyRevenue' => '$' . number_format($monthlyRevenue, 2, ',', '.'),
            'monthlyOrders' => (string) $monthlyOrders,
            'newCustomers' => (string) $newCustomers,
        ];

        return view('admin.dashboard', $data);
    }
}
