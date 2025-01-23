<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-no-repeat" style="background-image: url ('{{ asset('images/Background.png') }}')">
    <div class="max-w-7xl mx-auto p-5 grid grid-cols-1 sm:grid-cols-2 gap-5 mt-10">
        <!-- Left Top Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md flex items-start">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-32 h-30 rounded-lg mr-5">
            <div class="flex flex-col gap-2">
                <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                <p class="text-sm text-gray-600 flex items-center">
                    <img src="{{ asset('images/waktu.png') }}" alt="Time Icon" class="w-4 h-4 mr-1"> 10-15 menit
                </p>
                <p class="text-lg text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="flex items-center gap-2">
                    <span>Jumlah order: {{ $order['quantity'] }}</span>
                </div>
                <p class="mt-2 text-lg text-gray-700">Total Pembayaran: Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                <hr class="my-3">
                <h4 class="text-sm text-gray-700">Ada lagi yang mau dibeli?</h4>
                <p class="text-sm text-gray-600">Bisa tambah menu lain, ya!</p>
                <button class="bg-[#FF5722] text-white rounded-lg py-2 px-5 mt-2">Tambah</button>
            </div>
        </div>

        <!-- Right Top Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800">Alamat Restaurant</h3>
            <h4 class="text-sm text-gray-600">{{ $restaurant->address }}</h4>
            <p class="text-sm text-gray-600 flex items-center mt-1">
                <img src="{{ asset('images/jalan.png') }}" alt="Walking Icon" class="w-4 h-4 mr-1"> 10-15 menit
            </p>
            <button class="bg-[#FE724C] text-white rounded-lg py-2 px-5 mt-5">Lihat Alamat</button>
        </div>

        <!-- Left Bottom Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md">
            <label class="flex items-center font-semibold">
                <img src="{{ asset('images/alatmakan.png') }}" alt="Cutlery Icon" class="w-5 h-5 mr-2"> Minta alat makan atau sedotan
                <input type="checkbox" class="ml-2">
            </label>
            <hr class="my-3">
            <p class="text-sm text-[#94381A] underline mt-4">Cek promo menarik! <span class="font-bold">→</span></p>
        </div>

        <!-- Right Bottom Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800">Pilih Metode Pembayaran</h3>
            <div class="mt-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment-method" value="Card" class="h-5 w-5">
                    <img src="{{ asset('images/Card.png') }}" alt="Card Icon" class="w-6 h-6"> Online Payment
                </label>
                <hr class="my-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment-method" value="COD" class="h-5 w-5">
                    <img src="{{ asset('images/COD.png') }}" alt="COD Icon" class="w-6 h-6"> COD
                </label>
                <hr class="my-2">
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="flex justify-evenly py-5 max-w-7xl mx-auto">
        <button class="bg-[#FE724C] text-white py-2 px-6 rounded-lg shadow-lg">←</button>
        <a href="{{ route('customer.home') }}" class="bg-[#FE724C] text-white py-2 px-6 rounded-lg shadow-lg">
            Batalkan
        </a>        
        <form action="{{ route('order.now') }}" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $order['quantity'] }}">
            <input type="hidden" name="total" value="{{ $order['total'] }}">
            <input type="hidden" name="payment_method" value="Card">
            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
            <input type="hidden" name="address" value="{{ $restaurant->address }}">
            <button type="submit" class="bg-[#FE724C] text-white py-2 px-6 rounded-lg shadow-lg">
                Pesan Sekarang
            </button>
        </form>
    </div>
    
</body>
</html>
