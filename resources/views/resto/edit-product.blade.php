<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white w-96 p-6 rounded-lg shadow-lg relative">
        <!-- Close Button -->
        <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold" onclick="closeEditModal()">×</button>
        
        <!-- Modal Header -->
        <h2 class="text-xl font-bold text-gray-700 mb-4">Edit Product</h2>
        
        <!-- Form -->
        <form id="editForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Product Name -->
            <div class="mb-4">
                <label for="editName" class="block text-gray-700 font-semibold mb-2">Product Name</label>
                <input type="text" id="editName" name="name" placeholder="Enter product name" 
                       class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Price -->
            <div class="mb-4">
                <label for="editPrice" class="block text-gray-700 font-semibold mb-2">Price</label>
                <input type="number" id="editPrice" name="price" placeholder="Enter price" step="0.01"
                       class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Stock -->
            <div class="mb-4">
                <label for="editStock" class="block text-gray-700 font-semibold mb-2">Stock</label>
                <input type="number" id="editStock" name="stock" placeholder="Enter stock quantity"
                       class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <!-- Category -->
            <div class="mb-4">
                <label for="editCategory" class="block text-gray-700 font-semibold mb-2">Category</label>
                <select id="editCategory" name="category_id" 
                        class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <!-- Category Options -->
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Image -->
            <div class="mb-4">
                <label for="editImage" class="block text-gray-700 font-semibold mb-2">Product Image</label>
                <input type="file" id="editImage" name="image" 
                       class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <img id="previewImage" src="" alt="Preview" 
                     class="mt-3 h-20 w-20 object-cover rounded hidden">
            </div>
            
            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition font-bold">
                Save Changes
            </button>
        </form>
    </div>
</div>