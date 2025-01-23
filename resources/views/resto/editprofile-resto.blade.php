<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="main-section min-h-screen flex flex-col bg-fixed bg-no-repeat bg-right-top"
         style="background-image: url('{{ asset('images/background.jpg') }}');">
        <div class="container mx-auto px-4 py-10">
            <div class="flex flex-wrap">

                <!-- Sidebar -->
                <aside class="w-full md:w-1/3 lg:w-1/4 mb-6 md:mb-0">
                    <div class="bg-orange-500 text-white p-4 rounded-lg shadow-lg space-y-6">
                        <div class="text-center">
                            <img src="{{ $restaurant->profile_photo ? asset('storage/'.$restaurant->profile_photo) : asset('images/default-profile.jpg') }}"
                                 alt="Profile Photo" class="rounded-full h-32 w-32 object-cover mx-auto border-4 border-white">
                            <h4 class="font-semibold text-xl mt-2">{{ $restaurant->restaurant_name }}</h4>
                        </div>
                        <nav class="flex flex-col space-y-3">
                            <a href="{{ route('restaurant.home') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                Dashboard
                            </a>
                            <button onclick="location.href='#change-password'" 
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                Change Password
                            </button>
                            <button onclick="confirmDelete()"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                Delete Account
                            </button>
                        </nav>
                    </div>
                </aside>

                <!-- Account Settings Form -->
                <section class="w-full md:w-2/3 lg:w-3/4">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <div class="mb-6 p-6 rounded-lg" style="background-image: url('{{ asset('images/' . basename($restaurant->image_path)) }}'); background-size: cover; background-position: center; height: 200px;"></div>
                        <h5 class="text-xl font-bold mb-4 text-gray-800">Account Settings</h5>
                        <form action="{{ route('profile.update.resto') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <!-- Restaurant Name -->
                            <div class="mb-4">
                                <label for="restaurant_name" class="block text-gray-700 text-sm font-bold mb-2">Restaurant Name</label>
                                <input type="text" name="restaurant_name" value="{{ $restaurant->restaurant_name }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            </div>
                        
                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                                <input type="text" name="phone" value="{{ $restaurant->phone }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            </div>
                        
                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                                <textarea name="address" rows="3"
                                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-orange-500" required>{{ $restaurant->address }}</textarea>
                            </div>
                        
                            <!-- Profile Photo -->
                            <div class="mb-4">
                                <label for="profile_photo" class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                                <input type="file" name="profile_photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                            </div>
                        
                            <!-- Restaurant Photo -->
                            <div class="mb-4">
                                <label for="image_path" class="block text-gray-700 text-sm font-bold mb-2">Restaurant Photo</label>
                                <input type="file" id="image" name="image" accept="image/*" onchange="setImagePath()"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                                <input type="hidden" id="image_path" name="image_path" value="{{ $restaurant->image_path }}">
                                <p id="img-path" class="text-sm text-gray-600 mt-2">Current file: {{ basename($restaurant->image_path) }}</p>
                            </div>
                        
                            <!-- Submit Button -->
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Update Profile
                            </button>
                        </form>  
                        <form id="delete-form" action="{{ route('restaurant.delete', $restaurant->id) }}" method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                                          

    <script>
        // Update selected image file name
        document.getElementById('image').addEventListener('change', function(event) {
            const fileName = event.target.files[0]?.name || '';
            document.getElementById('image_path').value = fileName;
        });

        function confirmDelete() {
            if (confirm('Are you sure you want to delete your account?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
</body>
</html>