<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return redirect()->route('success.payment');
    }

    // product_id ; quantity ; total ; restaurant_id
    public function orderNow(Request $request)
    {
        // Store di session data Order + buka jendela midtrans

        $validated = $request->validate([
            'product_id' => 'required|integer|exists:product_tables,id',
            'quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:1',
            'restaurant_id' => 'required|integer|exists:restaurants,id',
        ]);

        // Menyimpan data pesanan ke sesi
        $request->session()->put('order', [
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'total' => $validated['total'],
            'restaurant_id' => $validated['restaurant_id'],
        ]);

        $user_id = auth()->id();
        if (!$user_id) {
            return redirect()->route('login');
        }

        $customer_id = \App\Models\Customer::where('user_id', $user_id)->first()->id;
        Log::info('customer_id: ' . $customer_id);
        $customer = \App\Models\Customer::find($customer_id);
        Log::info('customer: ' . $customer);
        $user = \App\Models\User::find($user_id);
        Log::info('user: ' . $user);

        // Redirect ke halaman pembayaran
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $validated['total'],
            ),
            'customer_details' => array(
                'first_name' => $customer->first_name,
                'last_name' => $customer->last_name,
                'email' => $user->email,
            ),
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $snapUrl = \Midtrans\Snap::getSnapUrl($params);

        Log::info('snapToken: ' . $snapToken);
        Log::info('snapUrl: ' . $snapUrl);

        return redirect($snapUrl);
    }
}
