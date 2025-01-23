<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/edit-product.js') }}" defer></script>
</head>

<body class="flex h-screen font-roboto z-30">
    <div class="flex w-full">
        @include('layouts.sidebar')
        <main class="ml-36 flex-1 bg-white flex flex-col p-5 pr-0 pb-o">
        @include('layouts.navbar')
        <section class="main-section flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: auto 100%;">
            <h1 class="text-4xl text-gray-800 font-bold mb-8">Welcome Back,<br> {{$restaurant->restaurant_name}}!</h1>
            <div class="w-72 p-6 bg-white rounded-2xl shadow-[10px_10px_20px_rgba(0,0,0,0.3)] border-2 border-black relative">
                <h2 class="text-gray-500 text-sm font-medium">Total Profit</h2>
                <p class="text-black text-3xl font-bold mt-4">Rp {{ number_format($totalProfit, 2) }}  </p>
                <button class="absolute top-4 right-4 bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                    Withdraw
                </button>
            </div>

            <!-- Best Seller Section -->
            <div class="mt-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Product Best Seller</h2>
                <div class="relative">
                    <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2"></button>
                    <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-5 p-5" style="scroll-snap-type: x mandatory;">
                        @forelse($bestSellingProducts as $product)
                            <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-xl shadow-md border-2 border-black overflow-hidden hover:bg-orange-400 transform hover:scale-105 transition duration-300">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-36 w-full rounded-t-xl object-cover">
                                <div class="pl-4 pr-4 pt-4 pb-2 flex items-center justify-between">
                                    <h3 class="font-bold">{{ $product->name }}</h3>
                                    <p class="text-sm text-black mt-1">Sold: {{ $product->sales }}</p>
                                </div>
                                <p class="ml-4 pb-4">Rp {{ number_format($product->price, 2) }}</p>

                            </div>
                        @empty
                        <div class="bg-orange-100 p-2 rounded-xl shadow-md border-2 border-black flex flex-col items-center justify-center">
                            <h3 class="font-bold text-center">Your Restaurant Doesn't Have a Best Product Yet.</h3>
                            <img src="{{ asset('images/sedih.png') }}" class="w-10 h-10 mt-4">
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Product</h2>
                <div class="relative mb-10">
                    <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 mb-4 z-10"></button>
                    <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-5 p-5" style="scroll-snap-type: x mandatory;">
                        @forelse($restaurant->products as $product)
                            <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-xl shadow-md border-2 border-grey-300 hover:bg-orange-400 transition duration-300 w-104">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-36 w-full rounded-t-xl object-cover transform hover:scale-110 hover:brightness-125 transition duration-300 hover:rounded-none">
                                <div class="pl-4 pr-4 pt-4 pb-2 flex items-center justify-between">
                                    <h3 class="font-bold">{{ $product->name }}</h3>
                                    <p>Rp {{ number_format($product->price, 2) }}</p>
                                </div>
                                    <p class="ml-4 pb-2">Stock: {{ $product->stock }}</p>

                                    <div class="flex justify-center gap-2 mt-1 mb-2">
                                    <button class="bg-blue-500 text-white font-bold px-4 py-1 rounded hover:bg-blue-600 transition"
                                    onclick="openEditModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }}, '{{ $product->category_id }}', '{{ asset('storage/' . $product->image) }}')">Edit  </button>
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                                        </form>
                                    </div>
                            </div>
                        @empty
                        <div class="bg-orange-100 p-2 rounded-xl shadow-md border-2 border-black flex flex-col items-center justify-center">
                            <h3 class="font-bold text-center">Your Restaurant Doesn't Have Product Yet.</h3>
                            <img src="{{ asset('images/sedih.png') }}" class="w-10 h-10 mt-4">
                        </div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-3 rounded mt-8">Add New Product</a>
            </div>
        </section>
        @include('resto.edit-product')
        
    </main>
</div>
<script src="{{ asset('js/edit-product.js') }}"></script>
</body>
</html>