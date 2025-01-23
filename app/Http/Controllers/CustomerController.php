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

class CustomerController extends Controller
{
    public function customerHome()
    {
        $restaurants = \App\Models\Restaurant::all();
        return view('customer.berandaCustomer', compact('restaurants'));
    }

    // delete customer
    public function deleteCustomer()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            // Hapus profil customer
            if ($user->customer) {
                $user->customer->delete();
            }
            // Hapus user
            $user->delete();
            // Redirect ke halaman home dengan pesan sukses
            return redirect('home')->with('success', 'Account deleted successfully.');
        }
        return back()->withErrors('Unauthorized access.');
    }

    // update customer
    public function updateCustomerProfile(Request $request)
    {
        $customer = Auth::user()->customer;
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'profile_photo' => 'nullable|image',
        ]);
        $customer->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $customer->profile_photo = $path;
        }

        return redirect()->route('customer.home')->with('success', 'Profile updated successfully.');
    }

    // view update profile customer
    public function editCustomerProfile()
    {
        // Pastikan user memiliki role "customer"
        if (Auth::user()->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }
        // Ambil data customer
        $customer = Auth::user()->customer;
        // Tampilkan view edit profile customer
        return view('customer.editprofile-customer', compact('customer'));
    }

    public function viewProducts($id)
    {
        $restaurant = \App\Models\Restaurant::find($id);
        $products = Product::where('restaurant_id', $id)->get();
        return view('customer.product_by_resto', compact('restaurant','products'));
    }

    public function productByCategory(Request $request, $category_id){
        $userAddress = $request->input('address'); // Ambil alamat dari input pengguna
        $product_category = \App\Models\ProductCategory::find($category_id);

        // Cari restoran yang memiliki alamat sesuai dengan input pengguna
        $restaurants = \App\Models\Restaurant::where('address', $userAddress)->pluck('id');

        // Ambil produk dari kategori ini yang hanya berasal dari restoran yang sesuai
        $products = \App\Models\Product::where('category_id', $category_id)
            ->whereIn('restaurant_id', $restaurants)
            ->get();

        return view('customer.product_by_category', compact('product_category', 'products', 'userAddress'));
    }

    public function test(){
        return view('customer.confirmOrder');
    }
}
