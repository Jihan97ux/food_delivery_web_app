<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RestaurantController extends Controller
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

        return redirect()->route('restaurant.home');
    }

    return redirect()->route('home')->with('error', 'Invalid role selected.');
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
            $request->session()->regenerate();
            return redirect()->route(Auth::user()->role . '.home');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }
}
