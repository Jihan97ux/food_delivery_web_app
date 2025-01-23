<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductCategory;

class RestaurantController extends Controller
{
    public function customerHome()
    {
        $restaurants = \App\Models\Restaurant::all();
        return view('customer.berandaCustomer', compact('restaurants'));
    }

    // Menampilkan form untuk memilih role
    public function showSelectRole()
    {
        return view('registration.select-role');
    }

    public function processRoleSelection(Request $request)
    {
    $role = $request->role;
    // Asumsikan Anda ingin mengarahkan pengguna ke form pendaftaran yang sesuai dengan role
    return redirect()->route('register.form', ['role' => $role]);
    }

    // Menampilkan form pendaftaran berdasarkan role
    public function showRegistrationForm(Request $request)
    {
        $role = $request->query('role');  // mengambil role dari URL
        if ($role === 'restaurant') {
            $categories = \App\Models\Category::all();
            return view('registration.register-resto',compact('categories'));
        } elseif ($role === 'customer') {
            return view('registration.register-customer');
        } else {
            return redirect()->route('home');
        }
    }

    // Proses pendaftaran
    public function register(Request $request)
    {
        $role = $request->input('role');
        if ($role === 'customer') {
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'date_of_birth' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed',
                // 'role' => 'required|in:customer,restaurant',

            ]);
    
            // Simpan data ke tabel `users`
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            // Simpan detail ke tabel `customers`
        $user->customer()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        Auth::login($user);

        return redirect()->route('customer.home');

    } elseif ($role === 'restaurant') {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'password' => 'required|confirmed',
            // 'role' => 'required|in:customer,restaurant',
        ]);

        // Simpan data ke tabel `users`
        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // 'role' => $validated['role'],
            'role' => 'restaurant'
        ]);

        // Simpan detail ke tabel `restaurants`
        $restaurant = $user->restaurant()->create([
            'restaurant_name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        $restaurant->categories()->attach($validated['categories']);
        Auth::login($user);

        return redirect()->route('show_add_image');
    }

    return redirect()->route('home')->with('error', 'Invalid role selected.');
}

    public function show_add_resto_pict(){
        return view('resto.add_pict');
    }

    public function add_resto_pict(Request $request)
    {
        $validated = $request->validate([
            'image_path' => 'required|string',
        ]);
    
        $restaurant = Auth::user()->restaurant;

        if ($restaurant) {
        // Update path gambar ke tabel restaurants
            $restaurant->update([
                'image_path' => $validated['image_path'],  // Menyimpan path gambar yang dikirim
            ]);

            return redirect()->route('restaurant.home')->with('success', 'Gambar berhasil ditambahkan!');
        }

        return redirect()->route('restaurant.home')->with('error', 'Gagal menambahkan gambar!');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('registration.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();
    
            // Ambil data role pengguna dari database
            $role = Auth::user()->role;
    
            // Arahkan pengguna ke halaman beranda sesuai role
            if ($role === 'customer') {
                return redirect()->route('customer.home');
            } elseif ($role === 'restaurant') {
                return redirect()->route('restaurant.home');
            } else {
                // Jika role tidak valid, logout dan kembali ke halaman login
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'role' => 'Invalid user role. Please contact support.',
                ]);
            }
        }
    
        // Jika autentikasi gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

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
        public function createProduct(){
            // Pastikan hanya restoran yang dapat mengakses
            if (!Auth::check() || Auth::user()->role !== 'restaurant') {
                return redirect()->route('login')->with('error', 'Unauthorized action.');
            }
            // Ambil kategori produk untuk dropdown
            $categories = \App\Models\ProductCategory::all();
            return view('resto.create-product', compact('categories'));
        }
    public function storeProduct(Request $request)
    {
        // Pastikan user adalah restoran
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            return redirect()->route('login')->with('error', 'Unauthorized action.');
        }
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Product name is required.',
            'price.required' => 'Price is required.',
            'stock.required' => 'Stock is required.',
            'category_id.required' => 'Please select a valid category.',
            'image.image' => 'Uploaded file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
        ]);
        // Simpan produk
        $product = new Product();
        $product->restaurant_id = Auth::user()->restaurant->id;
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
        if (!$product->save()) {
            return back()->with('error', 'Failed to add product. Please try again.');
        }
        $product->save();
        return redirect()->route('restaurant.home')->with('success', 'Product added successfully.');
    }
    public function editProductForm($id)
    {
        $product = Product::findOrFail($id);
        $categories = \App\Models\ProductCategory::all();
        return view('resto.edit-product', compact('product','categories'));
    }
    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
        ]);
        $product = Product::findOrFail($id);
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'];
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if($product->image){
                Storage::delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }
        $product->save();
        return redirect()->route('restaurant.home')->with('success', 'Product updated successfully.');
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete($product->image);
        $product->delete();
        return back()->with('success', 'Product deleted successfully.');
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