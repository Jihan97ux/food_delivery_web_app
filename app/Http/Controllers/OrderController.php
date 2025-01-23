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

        // Menyediakan data untuk dikirim ke view konfirmasi
        $orderData = [
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total' => $product->price * $validated['quantity'],
            'restaurant_id' => $product->restaurant_id,
        ];

        $restaurant = $product->restaurant; // Menambahkan informasi restoran

        // Mengirim data langsung ke view
        return view('customer.confirmOrder', [
            'order' => $orderData,
            'product' => $product,
            'restaurant' => $restaurant,
        ]);
    }

    public function confirmOrder(Request $request)
    {
        // Ambil data pesanan dari sesi
        $orderData = $request->session()->get('order');

        // Pastikan pesanan ada
        if (!$orderData) {
            return redirect()->route('order.create')->withErrors(['order' => 'No order data available.']);
        }

        // Récupération du produit
        $product = Product::findOrFail($orderData['product_id']);

        // Création de la commande
        $order = Order::create([
            'customer_id' => auth()->id(), // Assurez-vous que l'utilisateur est connecté
            'status' => 'pending',
            'restaurant_id' => $orderData['restaurant_id'],
            'total' => $orderData['total'],
        ]);

        // Création des détails de la commande
        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $orderData['quantity'],
            'price' => $product->price, // Prix à l'achat
        ]);

        // Mise à jour du stock du produit
        $product->decrement('stock', $orderData['quantity']);

        // Menghapus data pesanan dari sesi setelah konfirmasi
        $request->session()->forget('order');

        // Redirection vers la page souhaitée
        return redirect()->route('test')->with('success', 'Order created successfully!');
    }
}
