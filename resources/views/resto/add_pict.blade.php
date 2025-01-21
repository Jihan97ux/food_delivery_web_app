<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Picture</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .upload-container {
            text-align: center;
            margin-top: 50px;
        }

        .upload-container h1 {
            font-size: 24px;
            color: #ff7f50;
        }

        .upload-card {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-block;
            width: 300px;
        }

        .upload-card.active {
            border-color: #ff7f50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .upload-card img {
            width: 100px;
            height: 100px;
            transition: all 0.3s;
        }

        .upload-card img.inactive {
            filter: grayscale(100%);
        }

        .upload-card img.active {
            filter: grayscale(0);
        }

        .upload-card span {
            display: block;
            margin-top: 10px;
            color: #333;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff7f50;
            border: none;
            border-radius: 50px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #ff4500;
        }

        input[type="file"] {
            display: none;
        }

        .upload-card label {
            cursor: pointer;
            display: block;
        }
    </style>
    <link href="{{ asset('css/background.css') }}" rel="stylesheet">
</head>
<body>
    <div class="circle orange"></div>
    <div class="circle cream-bottom"></div>
    <div class="circle cream-top"></div>
    <div class="circle orange-top"></div>
    <div class="circle white-top"></div>
    <div class="circle cream-righttop"></div>
    <div class="circle orange-right"></div>
    <div class="circle orange-bottom-left"></div>
    <div class="circle white-bottom"></div>
    
    <div class="upload-container">
        <h1>Upload Image</h1>
        <div class="form-container">
            <form action="{{ route('add_image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="upload-card">
                    <label for="image">
                        <img src="{{ asset('images/upload_inactive.JPG') }}" alt="Upload" class="inactive">
                        <span>Choose an image</span>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*" required onchange="setImagePath()">
                </div>
                <input type="hidden" id="image_path" name="image_path">
                <br><br>
                <button type="submit">Submit</button>
            </form>
            <div id="img-path"></div>
        </div>  
    </div>

    <script>
        document.querySelector('.upload-card').addEventListener('click', function() {
            // Mengupdate gambar untuk menunjukkan status aktif
            const img = document.querySelector('.upload-card img');
            img.src = img.src.replace('_inactive', '_active');
            img.classList.remove('inactive');
            img.classList.add('active');
    
            // Menampilkan pesan status atau nama file setelah klik
            document.getElementById('img-path').innerText = 'Klik untuk memilih gambar';
        });

        // Mendapatkan input file setelah klik
        document.getElementById('image').addEventListener('change', function(event) {
            const fileInput = event.target;
            const filePath = fileInput.value; // Mendapatkan nama file
            document.getElementById('image_path').value = filePath;

            // Memisahkan filePath dengan '\\' dan mengambil bagian terakhir (nama file)
            const fileName = filePath.split("\\").pop();

            // Menampilkan nama file yang dipilih
            document.getElementById('img-path').innerText = `Selected file: ${fileName}`;
        });

    </script>
</body>
</html>