<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen font-roboto">
    <div class="flex w-full">
    @include('layouts.sidebar')
    <main class="ml-36 flex-1 bg-white flex flex-col p-10" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: 50% auto; background-position: calc(100% - 100px) center; background-repeat: no-repeat;">
        @include('layouts.navbar')
        <section class="main-section flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top">
            <div class="restaurant-temp flex gap-4 items-center mb-10">
                @php
                    $fileName = basename($restaurant->image_path);
                @endphp
                <!-- Gambar -->
                <img src="{{ asset('images/' . $fileName) }}" style="width: 40%; height: auto;" class="rounded-2xl shadow-md">
                
                <!-- Info Restoran -->
                <div class="restaurant-info flex flex-col p-5 ml-10">
                    <h3 class="mb-0">{{ $restaurant->restaurant_name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">15-25 mins</p>
                    <div class="tags flex flex-wrap gap-2 mt-2">
                        @foreach ($restaurant->categories as $category)
                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>            
            <h4 class="text-[22px] text-black/80"><b>Suggestion</b></h4>
            <div class="relative">
                <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-0 py-2 z-10"></button>
                <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-4 p-4 px-0" style="scroll-snap-type: x mandatory;">
                @foreach ($products as $product)
                    <div class="food-card bg-orange-100 rounded-2xl shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-auto" alt="{{ $product->name }}">
                        <div class="food-info p-5">
                            <div class="info-harga flex justify-between">
                                <h3 class="text-sm">{{ $product->name }}</h3>
                                <p class="text-sm">Rp.{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="stok-n-buy flex justify-between mt-4">
                                <!-- logika pengurangan stok tiap purchase perlu dijalankan -->
                                <p class="info-stok text-xs text-gray-500">stok : {{ $product->stock }}</p>
                                <div class="flex items-center gap-2">
                                    <!-- logika purchase ke order -->
                                    <form action="{{ route('customer.order') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input id="quantity-{{ $product->id }}" type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border rounded-sm text-sm shadow-sm focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out hover:scale-105" />
                                        <button type="submit" class="bg-orange-500 text-white text-sm px-3.5 py-1 rounded-full shadow-md hover:bg-orange-600 hover:shadow-lg transition duration-300 ease-in-out">
                                            Buy
                                        </button>
                                    </form>
                                </div>                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button onclick="scrollRight()" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 z-10"></button>
            </div>
        </section>        
    </main>
    </div>
</body>
</html>