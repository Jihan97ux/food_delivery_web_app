<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center bg-no-repeat" style="background-image: url('Background.png')">
    <div class="max-w-7xl mx-auto p-5 grid grid-cols-1 sm:grid-cols-2 gap-5 mt-10">
        <!-- Left Top Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md flex items-start">
            <img src="chicken_burger.JPG" alt="Chicken Burger" class="w-32 h-30 rounded-lg mr-5">
            <div class="flex flex-col gap-2">
                <h2 class="text-xl font-bold text-gray-800">Chicken Burger</h2>
                <p class="text-sm text-gray-600 flex items-center">
                    <img src="waktu.png" alt="Time Icon" class="w-4 h-4 mr-1"> 10-15 menit
                </p>
                <p class="text-lg text-gray-700">Rp 25.000</p>
                <div class="flex items-center gap-2">
                    <button class="bg-[#FE724C] text-white rounded-lg py-1 px-3">-</button>
                    <span>02</span>
                    <button class="bg-[#FE724C] text-white rounded-lg py-1 px-3">+</button>
                </div>
                <p class="mt-2 text-lg text-gray-700">Total Pembayaran: Rp 50.000</p>
                <hr class="my-3">
                <h4 class="text-sm text-gray-700">Ada lagi yang mau di beli?</h4>
                <p class="text-sm text-gray-600">Bisa tambah menu lain, ya!</p>
                <button class="bg-[#FF5722] text-white rounded-lg py-2 px-5 mt-2">Tambah</button>
            </div>
        </div>

        <!-- Right Top Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800">Alamat Restaurant</h3>
            <h1 class="text-xl font-bold text-gray-800">Jl. Teuku Nyak Arief</h1>
            <h4 class="text-sm text-gray-600">Kebayoran Lama, South Jakarta City</h4>
            <p class="text-sm text-gray-600 flex items-center mt-1">
                <img src="jalan.png" alt="Walking Icon" class="w-4 h-4 mr-1"> 10-15 menit
            </p>
            <button class="bg-[#FE724C] text-white rounded-lg py-2 px-5 mt-5">Lihat Alamat</button>
        </div>

        <!-- Left Bottom Box -->
        <div class="bg-[#FFECE7] rounded-lg p-5 shadow-md">
            <label class="flex items-center font-semibold">
                <img src="alatmakan.png" alt="Cutlery Icon" class="w-5 h-5 mr-2"> Minta alat makan atau sedotan
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
                    <img src="Card.png" alt="Card Icon" class="w-6 h-6"> Card
                </label>
                <hr class="my-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment-method" value="COD" class="h-5 w-5">
                    <img src="COD.png" alt="COD Icon" class="w-6 h-6"> COD
                </label>
                <hr class="my-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment-method" value="Gopay" class="h-5 w-5">
                    <img src="paypall.png" alt="Gopay Icon" class="w-6 h-6"> Gopay
                </label>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="flex justify-evenly py-5 max-w-7xl mx-auto">
        <button class="bg-[#FE724C] text-white py-2 px-6 rounded-lg shadow-lg">←</button>
        <button class="bg-[#FE724C] text-white py-2 px-6 rounded-lg shadow-lg">Batalkan</button>
        <button class="bg-gray-400 text-white py-2 px-6 rounded-lg shadow-lg">Pesan Sekarang</button>
    </div>
</body>
</html>
