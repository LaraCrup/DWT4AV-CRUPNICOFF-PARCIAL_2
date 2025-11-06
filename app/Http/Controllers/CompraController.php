<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraTorta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    /**
     * Mostrar la página de confirmación de compra
     */
    public function checkout()
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes estar autenticado para proceder al checkout');
        }

        return view('checkout');
    }

    /**
     * Procesar la compra (guardar en base de datos)
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar autenticado para realizar una compra'
            ], 401);
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Tu carrito está vacío'
            ], 422);
        }

        try {
            $compra = Compra::create([
                'usuario_id' => Auth::id(),
                'fecha_compra' => now()->toDateString(),
                'total' => $this->calculateTotal($cart),
            ]);

            foreach ($cart as $item) {
                CompraTorta::create([
                    'compra_id' => $compra->id,
                    'torta_id' => $item['torta_id'],
                    'tamano_id' => $item['tamano_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                ]);
            }

            session()->put('cart', []);

            return response()->json([
                'success' => true,
                'message' => 'Compra realizada exitosamente',
                'compra_id' => $compra->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la compra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalles de una compra específica
     */
    public function show(Compra $compra)
    {
        // Verificar que el usuario sea el dueño de la compra
        if ($compra->usuario_id !== Auth::id()) {
            abort(403);
        }

        $compra->load(['tortas' => function($query) {
            $query->with('tamanos');
        }]);

        return view('compraDetail', compact('compra'));
    }

    /**
     * Calcular el total del carrito
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['precio_unitario'] * $item['cantidad'];
        }
        return round($total, 2);
    }
}