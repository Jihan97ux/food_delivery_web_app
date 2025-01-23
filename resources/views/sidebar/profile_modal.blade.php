<div id="profilePopup" class="hidden absolute z-90 w-64 bg-gradient-to-br from-orange-200 to-orange-500 shadow-xl rounded-lg p-6"
    style="left: calc(100% + 1rem); top: 270px; transform: translateX(0);">
    <div class="flex items-center space-x-4 mb-4">
        <img src="{{ Auth::user()->role === 'restaurant' ? (Auth::user()->restaurant->profile_photo ? asset('storage/'.Auth::user()->restaurant->profile_photo) : asset('images/restaurant_active.png')) : (Auth::user()->customer->profile_photo ? asset('storage/'.Auth::user()->customer->profile_photo) : asset('images/customer_active.png')) }}" 
             alt="Profile Image" 
             class="h-14 w-14 rounded-full object-cover shadow-lg border-2 border-white">
        <div class="flex flex-col">
            <span class="text-lg font-bold text-white">
                {{ Auth::user()->role === 'restaurant' ? Auth::user()->restaurant->restaurant_name : Auth::user()->customer->first_name }}
            </span>
        </div>
    </div>
    
    <div class="space-y-2">
        <a href="{{ Auth::user()->role === 'restaurant' ? route('editprofile.resto') : route('editprofile.customer') }}"
           class="block w-full py-2 px-4 text-center bg-white text-orange-500 font-bold rounded-lg hover:bg-orange-200 hover:text-black transition duration-200 ease-in-out text-sm">
            Edit Profile
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="block w-full py-2 px-4 text-center bg-white text-orange-500 font-bold rounded-lg hover:bg-red-400 hover:text-white transition duration-200 ease-in-out text-sm">
            Logout
        </a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<script>
    function toggleProfilePopup() {
        var popup = document.getElementById('profilePopup');
        if (popup) {
            // Toggle visibility of the modal
            popup.classList.toggle('hidden');
        } else {
            console.error('Modal element not found');
        }
    }
</script>