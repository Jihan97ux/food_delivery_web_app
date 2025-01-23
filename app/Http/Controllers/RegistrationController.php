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

class RegistrationController extends Controller
{
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
                'profile_photo' => 'nullable|image|max:2048',
            ]);

            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'customer',
            ]);

            $customer = $user->customer()->create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'],
            ]);

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile_photos', 'public');
                $customer->update(['profile_photo' => $path]);
            }

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
                'profile_photo' => 'nullable|image|max:2048',
            ]);

            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'restaurant'
            ]);

            $restaurant = $user->restaurant()->create([
                'restaurant_name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('restaurant_photos', 'public');
                $restaurant->update(['restaurant_photo' => $path]);
            }

            $restaurant->categories()->attach($validated['categories']);
            Auth::login($user);

            return redirect()->route('show_add_image');
        }

        return redirect()->route('home')->with('error', 'Invalid role selected.');
    }

    public function show_add_resto_pict()
    {
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

    // logout customer dan resto
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/home'); // Atau arahkan pengguna ke halaman yang diinginkan setelah logout
    }

}
