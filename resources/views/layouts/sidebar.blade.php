<aside class="bg-orange-600 text-white w-40 h-screen fixed top-0 left-0 flex flex-col items-start p-5 space-y-5 rounded-tr-2xl rounded-br-2xl z-40">
    <div class="mb-10 w-full">
        <img src="{{ asset('images/logo.JPG') }}" class="w-4/5 mx-auto">
    </div>
    <nav class="space-y-10 w-full">
        <a href="{{ route(Auth::user()->role === 'restaurant' ? 'restaurant.home' : 'customer.home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/home.JPG') }}" class="w-8 h-8">
            <h4 class="text-sm hover:underline">Home</h4>
        </a>
        <a href="#" class="flex items-center space-x-2">
            <img src="{{ asset('images/category.JPG') }}" class="w-8 h-8">
            <h4 class="text-sm hover:underline">Category</h4>
        </a>
        <a href="javascript:void(0)" class="flex items-center space-x-2" onclick="toggleProfilePopup()">
            <img src="{{ asset('images/profile.JPG') }}" class="w-8 h-8">
            <h4 class="text-sm hover:underline">Profile</h4>
        </a>
        <a href="{{ route(Auth::user()->role === 'restaurant' ? 'restaurant.orders' : 'customer.home') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/order.JPG') }}" class="w-8 h-8">
            <h4 class="text-sm hover:underline">Order</h4>
        </a>
        <a href="#" class="flex items-center space-x-2">
            <img src="{{ asset('images/help.JPG') }}" class="w-8 h-8">
            <h4 class="text-sm hover:underline">Help</h4>
        </a>
    </nav>
    @include('sidebar.profile_modal')
</aside>
<script>
function toggleProfilePopup() 
{
var popup = document.getElementById('profilePopup');
if (popup) 
{
    popup.classList.toggle('hidden');
} 
else 
{
console.error('Modal element not found');
}
}
</script>
</body>
</html>