function openEditModal(id, name, price, stock, categoryId, imageUrl) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editForm').action = `/restaurant/products/update/${id}`;
    document.getElementById('editName').value = name;
    document.getElementById('editPrice').value = price;
    document.getElementById('editStock').value = stock;
    document.getElementById('editCategory').value = categoryId;
    const previewImage = document.getElementById('previewImage');
    if (imageUrl) {
        previewImage.src = imageUrl;
        previewImage.classList.remove('hidden');
    } else {
        previewImage.classList.add('hidden');
    }
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
const container = document.getElementById('restaurant-container');
        const scrollAmount = window.innerWidth * 0.90; // Adjust scroll amount based on desired view
        function scrollLeft() {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }
        function scrollRight() {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }