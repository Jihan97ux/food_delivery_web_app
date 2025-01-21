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
    <div class = "w-[32%]">
        @include('layouts.sidebar')
    </div>
    <div class="flex w-[90%]">
        <div class="w-full">
        <main class="flex-1 bg-white flex flex-col p-10">
            @include('layouts.navbar')
            <section class="main-section flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top" style="background-image: url('foto/background.JPG'); background-size: auto 110%;">
                <h1 class="text-4xl text-gray-700 p-15 mb-7"><b>What would you like to order</b></h1>
                <div class="flex gap-6 mb-7">
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/burger.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Burger</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/donut.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Donut</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/pizza.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Pizza</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/mexican.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Mexican</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/asian.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Asian</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/baverages.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Beverages</h4>
                    </button>
                </div>
                <h2 class="text-2xl"><b>Featured Restaurant</b></h2>
                <div class="relative">
                    <button onclick="scrollLeft()" class="absolute left-0 top-1/2 transform -translate-y-1/2 text-white px-0 py-2 z-10"></button>
                    <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-4 p-4 px-0" style="scroll-snap-type: x mandatory;">
                        <!-- Periksa apakah ada restoran -->
                        @if(isset($restaurants) && $restaurants->isNotEmpty())
                            @foreach ($restaurants as $restaurant)
                                <div class="scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-lg shadow-md overflow-hidden flex flex-col items-center" style="width: 20%; min-width: 300px;">
                                    @php
                                        $fileName = basename($restaurant->image_path);
                                    @endphp
                                    <img src="{{ asset('images/' . $fileName) }}" class="w-full h-1/2 object-cover object-top">
                                    <div class="p-4 text-center">
                                        <h3 class="text-md font-semibold">{{ $restaurant->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">15-25 mins</p>
                                        <div class="flex gap-1 justify-center mt-2 flex-wrap">
                                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">BURGER</span>
                                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">CHICKEN</span>
                                            <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">FAST FOOD</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-sm">No restaurants available at the moment.</p>
                        @endif
                    </div>                    
                    <button onclick="scrollRight()" class="absolute right-0 top-1/2 transform -translate-y-1/2 text-white px-4 py-2 z-10"></button>
                </div>
            </section>
        </main>
        </div>
    </div>
    <script>
        const container = document.getElementById('restaurant-container');
        const scrollAmount = window.innerWidth * 0.90; // Adjust scroll amount based on desired view

        function scrollLeft() {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }

        function scrollRight() {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    </script>
</body>
</html>