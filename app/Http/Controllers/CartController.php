<?php

namespace App\Http\Controllers;

use App\Models\Torta;
use App\Models\Tamano;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Obtener el carrito de la sesión del usuario
     */
    public function getCart(Request $request)
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'items' => $cart,
            'total' => $this->calculateTotal($cart)
        ]);
    }

    /**
     * Agregar un producto al carrito
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'torta_id' => 'required|exists:tortas,id',
            'tamano_id' => 'required|exists:tamanos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Obtener la torta y el tamaño
        $torta = Torta::findOrFail($validated['torta_id']);
        $tamano = Tamano::findOrFail($validated['tamano_id']);

        // Obtener el precio de la relación torta_tamano
        $tortaTamano = $torta->tamanos()->where('tamanos.id', $validated['tamano_id'])->first();

        if (!$tortaTamano) {
            return response()->json([
                'success' => false,
                'message' => 'Este tamaño no está disponible para esta torta'
            ], 422);
        }

        $precio = $tortaTamano->pivot->precio;

        // Obtener el carrito actual
        $cart = session()->get('cart', []);

        // Crear una clave única para el item (combinación de torta + tamaño)
        $itemKey = "torta_{$validated['torta_id']}_tamano_{$validated['tamano_id']}";

        // Si el item ya existe en el carrito, incrementar la cantidad
        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['cantidad'] += $validated['cantidad'];
        } else {
            // Agregar nuevo item al carrito
            $cart[$itemKey] = [
                'torta_id' => $validated['torta_id'],
                'tamano_id' => $validated['tamano_id'],
                'nombre' => $torta->nombre,
                'imagen' => $torta->imagen,
                'tamano_nombre' => $tamano->nombre,
                'precio_unitario' => $precio,
                'cantidad' => $validated['cantidad'],
            ];
        }

        // Guardar el carrito en la sesión
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'itemCount' => $this->getItemCount($cart)
        ]);
    }

    /**
     * Remover un producto del carrito
     */
    public function removeFromCart(Request $request)
    {
        $itemKey = $request->input('item_key');

        $cart = session()->get('cart', []);

        if (isset($cart[$itemKey])) {
            unset($cart[$itemKey]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto removido del carrito',
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'itemCount' => $this->getItemCount($cart)
        ]);
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'item_key' => 'required|string',
            'cantidad' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $itemKey = $validated['item_key'];

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['cantidad'] = $validated['cantidad'];
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada',
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'itemCount' => $this->getItemCount($cart)
        ]);
    }

    /**
     * Limpiar el carrito
     */
    public function clearCart()
    {
        session()->put('cart', []);

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado',
            'cart' => [],
            'total' => 0,
            'itemCount' => 0
        ]);
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

    /**
     * Obtener el contador de items en el carrito
     */
    private function getItemCount($cart)
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['cantidad'];
        }
        return $count;
    }
}