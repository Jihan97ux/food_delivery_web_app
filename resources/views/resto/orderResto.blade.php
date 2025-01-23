<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/edit-product.js') }}" defer></script>
</head>
<body class="flex h-screen font-roboto z-30">
    <div class="flex w-full">
        @include('layouts.sidebar')
        <main class="ml-40 flex-1 bg-white flex flex-col p-10 pr-0 pb-0">
            @include('layouts.navbar')
            <section class="main-section flex flex-col pl-8bg-fixed bg-no-repeat bg-right-top" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: auto 100%;">
                <h1 class="text-4xl text-gray-800 font-bold mt-10 mb-8">{{$restaurant->restaurant_name}} Order Management</h1>

                <!-- Baris pertama: Tanggal ganjil -->
                <div class="mt-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Most Recent Date Orders</h2>
                    <div class="relative">
                        <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 mb-4 z-10"></button>
                        <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-5 p-5" style="scroll-snap-type: x mandatory;">
                            @forelse($oddDates as $date)
                                <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-xl shadow-md border-2 border-black overflow-hidden hover:bg-orange-400 transform hover:scale-105 transition duration-300">
                                    <button 
                                        class="bg-orange-100 hover:bg-orange-300 text-black px-4 py-2 rounded-md shadow-md border-2 border-gray-400" 
                                        onclick="fetchOrderDetails('{{ $date }}', 'odd')">
                                        {{ $date }}
                                    </button>
                                </div>
                            @empty
                            <div class="bg-white p-2 rounded-3xl shadow-[10px_10px_20px_rgba(0,0,0,0.5)] border-2 border-black flex flex-col items-center justify-center">
                                <h3 class="font-bold text-center">Your Restaurant Doesn't Have Order Yet</h3>
                                <img src="{{ asset('images/sedih.png') }}" class="w-10 h-10 mt-4">
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Baris kedua: Tanggal genap -->
                <div class="mt-8 mb-5">
                    <div class="relative">
                        <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 mb-4 z-10"></button>
                        <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-5 p-5" style="scroll-snap-type: x mandatory;">
                            @forelse($evenDates as $date)
                            <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-xl shadow-md border-2 border-black overflow-hidden hover:bg-orange-400 transform hover:scale-105 transition duration-300">
                                <button 
                                    class="bg-white p-2 rounded-3xl shadow-[10px_10px_20px_rgba(0,0,0,0.5)] border-2 border-black hover:bg-orange-300 text-black px-4 py-2" 
                                    onclick="fetchOrderDetails('{{ $date }}', 'even')">
                                    {{ $date }}
                                </button>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Baris ketiga: Last Customer -->
                <div class="mt-8 mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Last Customers</h2>
                    <div class="relative">
                        <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 mb-4 z-10"></button>
                        <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-5 p-5" style="scroll-snap-type: x mandatory;">
                            @if($lastCustomer)
                            <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-xl shadow-md border-2 border-black overflow-hidden hover:bg-orange-400 transform hover:scale-105 transition duration-300">
                                <div class="flex flex-col items-center bg-orange-100 rounded-xl shadow-md border border-gray-300 p-5">
                                    <img src="{{ asset('storage/' . $lastCustomer->profile_photo) }}" 
                                         alt="{{ $lastCustomer->name }}" 
                                         class="w-24 h-24 rounded-full object-cover">
                                    <h3 class="text-lg font-bold mt-4">{{ $lastCustomer->name }}</h3>
                                    <p class="text-gray-600">Purchased: {{ $lastCustomer->order_date }}</p>
                                </div>
                                <div class="flex-1 bg-white shadow-md p-5 rounded-lg border border-gray-200">
                                    <h3 class="font-bold text-xl mb-4">Order Details</h3>
                                    @foreach($lastCustomer->orders as $order)
                                    <div class="mb-4">
                                        <p class="text-gray-800">Menu: {{ $order->product->name }}</p>
                                        <p class="text-gray-800">Quantity: {{ $order->quantity }}</p>
                                        <p class="text-gray-800">Total: Rp {{ number_format($order->price * $order->quantity, 2) }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="bg-orange-100 p-2 rounded-xl shadow-md border-2 border-black flex flex-col items-center justify-center">
                                <h3 class="font-bold text-center">Your Restaurant Doesn't Have Customer Yet.</h3>
                                <img src="{{ asset('images/sedih.png') }}" class="w-10 h-10 mt-4">
                            </div>
                            @endif
                </div>
            </section>
        </main>
    </div>
    <script>
        function fetchOrderDetails(date, type) {
            alert(`Fetching orders for ${type} date: ${date}`);
        }
    </script>
</body>
</html>