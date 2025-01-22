<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:product_tables,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Récupération du produit
        $product = Product::findOrFail($validated['product_id']);

        // Vérification du stock
        if ($product->stock < $validated['quantity']) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        // Création de la commande
        $order = Order::create([
            'customer_id' => auth()->id(), // Assurez-vous que l'utilisateur est connecté
            'status' => 'pending',
            'restaurant_id' => $product->restaurant_id,
            'total' => $product->price * $validated['quantity'],
        ]);

        // Création des détails de la commande
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'price' => $product->price, // Prix à l'achat
        ]);

        // Mise à jour du stock du produit
        $product->decrement('stock', $validated['quantity']);

        // Redirection vers la page souhaitée
        return redirect()->route('customer.home')->with('success', 'Order created successfully!');
    }
}
