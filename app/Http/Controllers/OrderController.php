<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;

class OrderController extends Controller
{
    public function saveOrder(Request $request, $restaurantId)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product_tables,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return redirect()->back()->with('error', 'Stok tidak cukup');
        }

        // Simpan data pesanan sementara di session
        $orderData = [
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'restaurant_id' => $restaurantId,
            'product_price' => $product->price,
        ];

        session(['order_data' => $orderData]);

        return redirect()->route('order.confirm');
    }

    public function confirmOrder()
    {
        // Ambil data pesanan dari session
        $orderData = session('order_data');

        if (!$orderData) {
            return redirect()->route('order.create')->with('error', 'Data pesanan tidak ditemukan');
        }

        $product = Product::find($orderData['product_id']);
        $customer = Customer::where('user_id', auth()->id())->first();

        $totalPrice = $product->price * $orderData['quantity'];

        // Simpan pesanan ke database
        $order = Order::create([
            'customer_id' => $customer->id,
            'restaurant_id' => $orderData['restaurant_id'],
            'total' => $totalPrice,
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $orderData['quantity'],
            'price' => $product->price,
        ]);

        $product->stock -= $orderData['quantity'];
        $product->save();

        // Hapus data pesanan dari session setelah disimpan
        session()->forget('order_data');

        return redirect()->route('order.success')->with('success', 'Pesanan berhasil dibuat');
    }
}
