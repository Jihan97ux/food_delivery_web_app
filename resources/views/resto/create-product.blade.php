@extends('layouts.background')

@section('content')
<div class="max-w-xl w-full mx-auto p-2 bg-orange-400 rounded-lg shadow-lg text-center">
    <h1 class="text-xl font-bold text-white mt-1 mb-4">Add a New Product</h1>
    <div class="bg-white p-10 rounded-lg shadow-md">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" placeholder="Product Name" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <input type="number" name="price" step="0.01" placeholder="Price" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <input type="number" name="stock" placeholder="Stock" required class="w-full p-3 border border-gray-300 rounded" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select name="category_id" id="category_id" class="w-full p-3 border border-gray-300 rounded">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
                <input type="file" id="image" name="image" class="w-full p-3 border border-gray-300 rounded">
            </div>
            <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full shadow font-bold mb-6 transition duration-300">Add Product
       