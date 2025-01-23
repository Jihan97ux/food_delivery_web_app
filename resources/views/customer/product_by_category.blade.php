<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product_category->name ?? 'Foods Category' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex h-screen font-roboto">
    <div class="flex w-full">
        @include('customer.sidebar')
        <main class="ml-36 flex-1 bg-white flex flex-col p-10" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: 50% auto; background-position: calc(100% - 100px) center; background-repeat: no-repeat;">
            <header class="mb-6">
                <h1 class="text-2xl font-bold">{{ $product_category->name ?? 'Unknown Category' }}</h1>
                <div class="text-sm text-gray-700 mt-2">
                    Sort by: <span class="text-orange-500 cursor-pointer">Popular</span>
                </div>
            </header>
            <section class="space-y-10 max-w-3xl">
                <!-- Product Card -->
                @forelse ($products as $product)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-48 object-cover"
                        >
                        <div class="flex items-center justify-between space-x-6 p-4 pl-5 pr-10 bg-white rounded-lg shadow-md">
                            <!-- Informasi Produk -->
                            <div>
                                <div class="text-orange-500 text-lg font-bold">
                                    Rp.{{ number_format($product->price, 0, ',', '.') }}
                                </div>
                                <h3 class="text-lg font-medium mt-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    Stock: {{ $product->stock }}
                                </p>
                                <div class="text-sm text-gray-500 mt-2">
                                    4.5 <span>(25+)</span>
                                </div>
                            </div>
                        
                            <!-- Form untuk Pembelian -->
                            <form action="{{ route('customer.order') }}" method="POST" class="flex items-center space-x-3">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input id="quantity-{{ $product->id }}" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                    class="w-16 text-center border rounded-md text-sm shadow-sm focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out hover:scale-105" />
                                <button 
                                    type="submit" 
                                    class="bg-orange-500 text-white text-sm px-4 py-2 rounded-full shadow-md hover:bg-orange-600 hover:shadow-lg transition duration-300 ease-in-out">
                                    Buy
                                </button>
                            </form>
                        </div>                        
                    </div>
                @empty
                    <p class="text-gray-500">No products found in this category.</p>
                @endforelse
            </section>
        </main>
    </div>
</body>
</html>
