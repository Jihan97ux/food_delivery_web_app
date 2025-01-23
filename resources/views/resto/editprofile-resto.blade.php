<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="main-section min-h-screen flex flex-col pl-8 bg-fixed bg-no-repeat bg-right-top" style="background-image: url('{{ asset('images/background.jpg') }}');">
        <div class="container mx-auto px-2 py-10">
            <div class="flex flex-wrap">
                <!-- Sidebar for profile options -->
                <div class="w-full md:w-1/3 lg:w-1/4 mb-4">
                    <div class="bg-orange-500 text-white p-4 rounded-lg shadow-xl space-y-4 transition duration-500 ease-in-out transform hover:-translate-y-1 hover:shadow-2xl">
                        <div class="text-center">
                            <img src="{{ $restaurant->profile_photo ? asset('storage/'.$restaurant->profile_photo) : asset('images/default-profile.jpg') }}"
                                 class="rounded-full h-32 w-32 object-cover mx-auto border-4 border-white" alt="Profile Photo">
                            <h4 class="font-semibold text-xl mt-2">{{ $restaurant->restaurant_name }}</h4>
                        </div>
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('restaurant.home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <button onclick="location.href='#change-password'" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                            <button onclick="confirm('Are you sure you want to delete your account?') && document.getElementById('delete-form').submit();"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center">
                                <i class="fas fa-trash-alt"></i> Delete Account
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account settings form -->
                <div class="w-full md:w-2/3 lg:w-3/4">
                    <div class="bg-orange-100 shadow-lg rounded-lg p-5">
                        <div class="mb-4 border-b p-20" style="background-image: url('{{ $restaurant->restaurant_photo ? asset('storage/'.$restaurant->restaurant_photo) : asset('images/default-restaurant.jpg') }}'); background-size: cover;">
                            <h5 class="font-bold text-xl text-white">Account Settings</h5>
                        </div>
                        <div class="mb-6">
                            <form action="{{ route('profile.update.resto') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="restaurant_name" class="block text-gray-700 text-sm font-bold mb-2">Restaurant Name</label>
                                    <input type="text" name="restaurant_name" value="{{ $restaurant->restaurant_name }}"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                                    <input type="text" name="phone" value="{{ $restaurant->phone }}"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                </div>
                                <div class="mb-4">
                                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                                    <textarea name="address" rows="3"
                                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $restaurant->address }}</textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="profile_photo" class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control-file">
                                </div>
                                <div class="mb-4">
                                    <label for="restaurant_photo" class="block text-gray-700 text-sm font-bold mb-2">Restaurant Photo</label>
                                    <input type="file" name="restaurant_photo" class="form-control-file">
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="delete-form" action="{{ route('restaurant.delete', $restaurant->id) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>