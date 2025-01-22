<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-orange-600 text-white w-36 flex flex-col items-start p-5 space-y-5 rounded-tr-2xl rounded-br-2xl sticky top-0 h-screen">
        <div class="mb-10 w-full">
            <img src="{{ asset('images/logo.JPG') }}" class="w-4/5 mx-auto">
        </div>
        <nav class="space-y-10 w-full">
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/home.JPG') }}" class="w-8 h-8">
                <h4 class="text-sm hover:underline">Home</h4>
            </a>
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/category.JPG') }}" class="w-8 h-8">
                <h4 class="text-sm hover:underline">Category</h4>
            </a>
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/profile.JPG') }}" class="w-8 h-8">
                <h4 class="text-sm hover:underline">Profile</h4>
            </a>
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/order.JPG') }}" class="w-8 h-8">
                <h4 class="text-sm hover:underline">Order</h4>
            </a>
            <a href="#" class="flex items-center space-x-2">
                <img src="{{ asset('images/help.JPG') }}" class="w-8 h-8">
                <h4 class="text-sm hover:underline">Help</h4>
            </a>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
