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
    <main class="ml-36 flex-1 bg-white flex flex-col p-10" style="background-image: url('{{ asset('images/background.jpg') }}'); background-size: 47% auto; background-position: calc(100% - 100px) center; background-repeat: no-repeat;">
            @include('layouts.navbar')
            <!-- Pop-up untuk alamat -->
            <div id="addressModal" class="fixed top-5 right-5 bg-white p-5 rounded-lg shadow-lg z-50">
                <h3 class="text-lg mb-3">Masukkan Alamat Pemesanan</h3>
                <input id="addressInput" type="text" class="p-2 border border-gray-300 rounded-md w-64" placeholder="Alamat Anda">
                <button id="submitAddress" class="mt-3 bg-orange-500 text-white p-2 rounded-lg">Masukkan Alamat</button>
            </div>

            <!-- Tombol ubah alamat yang muncul setelah alamat ditambahkan -->
            <div id="addressButton" class="hidden fixed top-[100px] right-5 bg-orange-500 p-3 rounded-full shadow-lg z-50">
                <button id="changeAddressButton" class="text-white">Alamat Pemesanan</button>
            </div>

            <section class="main-section flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top">
                <h1 class="text-4xl text-gray-700 p-15 mb-7"><b>What would you like to order</b></h1>
                <div class="flex gap-6 mb-7">
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/burger.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Fast Food</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/donut.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Sweets</h4>
                    </button>
                    <button class="flex flex-col items-center bg-white text-gray-600 w-20 h-36 rounded-full shadow-md hover:bg-orange-500 hover:text-white transition duration-300">
                        <img src="{{ asset('images/pizza.JPG') }}" class="w-full h-auto mb-2 rounded-full p-1">
                        <h4 class="text-sm">Italian</h4>
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
                    <!-- Perbaikan Blade Template -->
                    <div id="restaurant-container" class="flex overflow-x-auto scrollbar-hide gap-4 p-4 px-0" style="scroll-snap-type: x mandatory;">
                        @if(isset($restaurants) && $restaurants->isNotEmpty())
                            @foreach ($restaurants as $restaurant)
                            <a href="{{ route('customer.products', ['id' => $restaurant->id]) }}">
                                <div class="restaurant-card scroll-snap-align start flex-shrink-0 bg-orange-100 rounded-lg shadow-md overflow-hidden flex flex-col items-center" data-address="{{ $restaurant->address }}" style="width: 20%; min-width: 300px;">
                                    <img src="{{ asset('images/' . basename($restaurant->image_path)) }}" class="w-full h-1/2 object-cover object-top">
                                    <div class="p-4 text-center">
                                        <h3 class="text-md font-semibold">{{ $restaurant->restaurant_name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ $restaurant->address }}</p>
                                        <div class="flex gap-1 justify-center mt-2 flex-wrap">
                                            @foreach ($restaurant->categories as $category)
                                                <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </a>
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
    <script>
        const container = document.getElementById('restaurant-container');
        const scrollAmount = window.innerWidth * 0.90; // Adjust scroll amount based on desired view

        function scrollLeft() {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }

        function scrollRight() {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }

        // Cek apakah sudah ada alamat yang disimpan di localStorage
        const savedAddress = localStorage.getItem('userAddress');

        // Menampilkan tombol ubah alamat jika alamat sudah ada
        if (savedAddress) {
            addressButton.classList.remove('hidden');
            addressModal.classList.add('hidden');
            filterRestaurantsByAddress(savedAddress);
        }

        // Filter restoran berdasarkan alamat
        function filterRestaurantsByAddress(address) {
            const restaurants = document.querySelectorAll('.restaurant-card');
            restaurants.forEach(restaurant => {
                const restaurantAddress = restaurant.getAttribute('data-address'); // Ambil alamat dari data attribute
                if (restaurantAddress && restaurantAddress !== address) {
                    restaurant.style.display = 'none';
                } else {
                    restaurant.style.display = 'flex';
                }
            });
        }

        // Mengubah status tampilan modal dan tombol ubah alamat
        submitAddress.addEventListener('click', function () {
            const address = addressInput.value.trim();
            if (address) {
                // Sembunyikan modal dan tampilkan tombol ubah alamat
                addressModal.classList.add('hidden');
                addressButton.classList.remove('hidden');
                // Simpan alamat ke dalam localStorage
                localStorage.setItem('userAddress', address);
                // Filter restoran berdasarkan alamat
                filterRestaurantsByAddress(address);
            }
        });

        // Menampilkan modal untuk mengubah alamat
        changeAddressButton.addEventListener('click', function () {
            addressModal.classList.remove('hidden');
            addressButton.classList.add('hidden');
            addressInput.value = localStorage.getItem('userAddress') || '';
        });

    </script>
</body>
</html>