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

class ProductController extends Controller
{
    public function createProduct(){
        // Pastikan hanya restoran yang dapat mengakses
        if (!Auth::check() || Auth::user()->role !== 'restaurant') {
            return redirect()->route('login')->with('error', 'Unauthorized action.');
        }
        // Ambil kategori produk untuk dropdown
        $restaurant = Auth::user()->restaurant;
        $categories = \App\Models\ProductCategory::all();
        return view('resto.create-product', compact('categories', 'restaurant'));
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

}
