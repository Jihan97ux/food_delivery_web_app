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
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{

    public function restaurantHome()
    {
        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            // Redirect user atau tampilkan pesan error jika tidak ada data restoran
            return redirect()->route('home')->withErrors('No restaurant data found for the current user.');
        }

        // Menghitung total profit langsung di query database
        $totalProfit = DB::table('orders')
            ->join('order_detail', 'orders.id', '=', 'order_detail.order_id')
            ->where('orders.restaurant_id', $restaurant->id)
            ->sum(DB::raw('order_detail.price * order_detail.quantity'));

        // Mengambil produk terlaris dengan lebih efisien
        $bestSellingProducts = $restaurant->products()
            ->withCount(['orderDetails as sales' => function ($query) {
                $query->select(DB::raw("SUM(quantity)"));
            }])
            ->orderBy('sales', 'desc')
            ->take(4)
            ->get();

        // Mengambil semua kategori produk
        $categories = ProductCategory::all();

        return view('resto.berandaResto', compact('restaurant', 'totalProfit', 'bestSellingProducts', 'categories'));
    }

    public function updateRestaurantProfile(Request $request)
    {
        // Validasi request
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|max:2048', // Tambahkan batas ukuran file
            'image_path' => 'required|string',
        ]);

        try {
            // Log data request untuk debug
            Log::info('Update request received: ', $request->all());

            // Ambil data restaurant dari user yang sedang login
            $restaurant = Auth::user()->restaurant;

            if (!$restaurant) {
                Log::error('Restaurant profile not found for user ID: ' . Auth::id());
                return redirect()->back()->withErrors('Restaurant profile not found.');
            }

            // Update restaurant details
            $restaurant->update([
                'restaurant_name' => $request->restaurant_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'image_path' => $request->image_path,
            ]);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                if ($path) {
                    Log::info('Profile photo uploaded successfully: ' . $path);
                    $restaurant->profile_photo = $path;
                } else {
                    Log::error('Failed to upload profile photo.');
                }
            }

            // Save restaurant profile
            $restaurant->save();
            Log::info('Restaurant profile updated successfully: ', $restaurant->toArray());

            return redirect()->route('restaurant.home')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Update profile failed: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to update profile. Please try again.');
        }
    }

    // view untuk edit profile resto
    public function editRestaurantProfile()
    {
        $restaurant = Auth::user()->restaurant;
        return view('resto.editprofile-resto', compact('restaurant'));
    }

    public function deleteRestaurant($id)
    {
        try {
            // Cari restoran berdasarkan ID
            $restaurant = Restaurant::findOrFail($id);

            // Periksa apakah user memiliki hak untuk menghapus restoran ini
            if (Auth::id() !== $restaurant->user_id) {
                \Log::warning('Unauthorized delete attempt', [
                    'auth_id' => Auth::id(),
                    'restaurant_user_id' => $restaurant->user_id
                ]);
                return redirect()->route('home')->withErrors('You are not authorized to delete this restaurant.');
            }

            // Hapus file foto terkait jika ada
            if ($restaurant->profile_photo && Storage::exists($restaurant->profile_photo)) {
                Storage::delete($restaurant->profile_photo);
            }

            if ($restaurant->restaurant_photo && Storage::exists($restaurant->restaurant_photo)) {
                Storage::delete($restaurant->restaurant_photo);
            }

            // Hapus restoran dari database
            $restaurant->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('home')->with('success', 'Restaurant deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete restaurant', [
                'error' => $e->getMessage(),
                'restaurant_id' => $id
            ]);

            // Redirect dengan pesan error
            return redirect()->route('home')->withErrors('Failed to delete the restaurant. Please try again later.');
        }
    }


    public function showOrders()
    {
        $user = Auth::user();
        if ($user->role !== 'restaurant') {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        $restaurant = $user->restaurant;

        // Fetch odd dates
        $oddDates = DB::table('order_detail')
            ->select(DB::raw('DATE(created_at) as date'))
            ->whereRaw('DAY(created_at) % 2 = 1')
            ->groupBy('date')
            ->pluck('date');

        // Fetch even dates
        $evenDates = DB::table('order_detail')
            ->select(DB::raw('DATE(created_at) as date'))
            ->whereRaw('DAY(created_at) % 2 = 0')
            ->groupBy('date')
            ->pluck('date');

        // Fetch last order and customer
        $lastOrder = DB::table('orders')
            ->join('customers', 'customers.user_id', '=', 'orders.customer_id')
            ->join('users', 'users.id', '=', 'orders.customer_id')
            ->selectRaw("CONCAT(customers.first_name, ' ', customers.last_name) as name, customers.profile_photo, orders.created_at as order_date, orders.id")
            ->orderByDesc('orders.created_at')
            ->first();

        $lastCustomer = null;
        if ($lastOrder) {
            $lastCustomer = (object) [
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

        return view('resto.orderResto', compact('restaurant', 'oddDates', 'evenDates', 'lastCustomer'));
    }


}