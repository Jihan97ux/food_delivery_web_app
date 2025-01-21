<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="flex h-screen font-roboto">
<div class="flex w-full">
    @include('layouts.sidebar')
    <main class="flex-1 bg-white flex flex-col p-10">
        @include('layouts.navbar')
        <section class="main-section flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top" style="background-image: url('images/background.JPG'); background-size: auto 110%;">
            <!-- Header -->
            <h1 class="text-4xl text-gray-800 font-bold mb-5">Welcome Back, McDonalds</h1>
            
            <!-- Total Profit Card -->
            <div class="w-72 p-10 mb-8 bg-white rounded-lg shadow-xl border border-gray-200 relative">
                <h2 class="text-gray-500 text-sm font-medium">Total Profit</h2>
                <p class="text-black text-3xl font-bold mt-4">Rp 2.500.000</p>
                <button class="absolute top-4 right-4 bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                    Withdraw
                </button>
            </div>

            <!-- Best Seller Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-5">Your Product Best Seller</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-orange-100 rounded-xl shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/chicken_burger.jpg') }}" class="w-full h-36 object-cover">
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Chicken Burger</h3>
                                <p class="text-sm text-gray-500 mt-1">Rp 25.000</p>
                            </div>
                            <button class="bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                                Stok: 30
                            </button>
                        </div>
                    </div>                    
                    <!-- Card 2 -->
                    <div class="bg-orange-100 rounded-xl shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/french_fries.jpg') }}" class="w-full h-36 object-cover">
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">French Fries</h3>
                                <p class="text-sm text-gray-500 mt-1">Rp 25.000</p>
                            </div>
                            <button class="bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                                Stok: 40
                            </button>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-orange-100 rounded-xl shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/happy_meal.jpg') }}" class="w-full h-36 object-cover">
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Happy Meal</h3>
                                <p class="text-sm text-gray-500 mt-1">Rp 30.000</p>
                            </div>
                            <button class="bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                                Stok: 30
                            </button>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-orange-100 rounded-xl shadow-md overflow-hidden flex flex-col">
                        <img src="{{ asset('images/happy_meal.jpg') }}" class="w-full h-36 object-cover">
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">Happy Meal</h3>
                                <p class="text-sm text-gray-500 mt-1">Rp 30.000</p>
                            </div>
                            <button class="bg-gray-100 text-gray-600 text-xs px-4 py-1 rounded-full border border-red-400 hover:bg-red-50">
                                Stok: 30
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>