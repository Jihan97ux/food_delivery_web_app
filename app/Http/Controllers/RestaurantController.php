<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductCategory;

class RestaurantController extends Controller
{

    public function restaurantHome(){
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            // Redirect user atau tampilkan pesan error jika tidak ada data restoran
            return redirect()->route('home')->withErrors('No restaurant data found for the current user.');
        }
        // Mengambil total pendapatan dengan lebih efisien
        $totalProfit = $restaurant->orders()->with('orderDetails')
            ->get()
            ->reduce(function ($carry, $order) {
                return $carry + $order->orderDetails->sum('total');
            }, 0);
        // Mengambil produk terlaris dengan lebih efisien
        $bestSellingProducts = $restaurant->products()
            ->withCount(['orderDetails as sales' => function ($query) {
                $query->select(\DB::raw("SUM(quantity)"));
            }])
            ->orderBy('sales', 'desc')
            ->take(4)
            ->get();
            $categories = ProductCategory::all();
        return view('resto.berandaResto', compact('restaurant', 'totalProfit', 'bestSellingProducts','categories'));
    }

    // update resto profile
    public function updateRestaurantProfile(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image',
            'restaurant_photo' => 'nullable|image'
        ]);
        $restaurant = Auth::user()->restaurant;
        $restaurant->update([
            'restaurant_name' => $request->restaurant_name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        // Handle file upload for profile photo
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $restaurant->profile_photo = $path;
        }
        if ($request->hasFile('restaurant_photo')) {
            $path = $request->file('restaurant_photo')->store('restaurant_photos', 'public');
            $restaurant->restaurant_photo = $path;
        }
        $restaurant->save();
        return redirect()->route('restaurant.home')->with('success', 'Profile updated successfully.');
    }

    // view untuk edit profile resto
    public function editRestaurantProfile()
    {
        $restaurant = Auth::user()->restaurant;
        return view('resto.editprofile-resto', compact('restaurant'));
    }

    // delete restaurant
    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        // Lakukan logika penghapusan, misalnya menghapus foto terkait, dan lainnya
        Storage::delete($restaurant->profile_photo);
        Storage::delete($restaurant->restaurant_photo);
        // Hapus restoran dari database
        $restaurant->delete();
        // Redirect ke halaman utama atau mana pun yang Anda inginkan dengan pesan sukses
        return redirect()->route('home')->with('success', 'Restaurant deleted successfully.');
    }

    // show order ke resto
    public function showOrders(){
        $user = Auth::user();
        if($user->role !== 'restaurant'){
            return redirect()->route('home')->with('error','Unauthorized acces');
        }

        $restaurant = $user->restaurant;
        $oddDates = DB::table('order_detail')
        ->select(DB::raw('Date(created_at) as date'))
        ->whereRaw('DAY(created_at) % 2 = 1')
        ->groupBy('date')
        ->pluck('date');
        $evenDates = DB::table('order_detail')
        ->select(DB::raw('DATE(created_at) as date'))
        ->whereRaw('DAY(created_at) % 2 = 0')
        ->groupBy('date')
        ->pluck('date');
        $lastOrder = DB::table('orders')
        ->join('customers', 'customers.user_id', '=', 'orders.customer_id')
        ->join('users', 'users.id', '=', 'orders.customer_id')
        ->selectRaw("CONCAT(customers.first_name, ' ', customers.last_name) as name, customers.profile_photo, orders.created_at as order_date, orders.id")
        ->orderByDesc('orders.created_at')
        ->first();
        $lastCustomer = null;
    if ($lastOrder) 
        {
            $lastCustomer = (object) 
            [
                'name' => $lastOrder->name,
                'profile_photo' => $lastOrder->profile_photo,
                'order_date' => $lastOrder->order_date,
                'orders' => DB::table('order_detail')
                    ->join('product_tables', 'product_tables.id', '=', 'order_detail.product_id')
                    ->where('order_detail.order_id', $lastOrder->id)
                    ->select('product_tables.name as product_name', 'order_detail.quantity', 'order_detail.price')
                    ->get(),
            ];
        }
        return view('resto.orderResto', compact('restaurant','oddDates', 'evenDates', 'lastCustomer'));
    }

}