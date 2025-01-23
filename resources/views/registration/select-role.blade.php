<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .role-container {
            text-align: center;
            margin-top: 50px;
        }

        .role-container h1 {
            font-size: 24px;
            color: #ff7f50;
        }

        .role-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .role-card {
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .role-card.active {
            border-color: #ff7f50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .role-card img {
            width: 80px;
            height: 80px;
            transition: all 0.3s;
        }

        .role-card img.inactive {
            filter: grayscale(100%);
        }

        .role-card img.active {
            filter: grayscale(0);
        }

        .role-card span {
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
            top: 100%;
            left: 100%;
        }

        button:hover {
            background-color: #ff4500;
            top: -30px;
            left: -30px;
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
    
    <div class="register-container">
        <h1>Select Role</h1>
        <div class="form-container">
        <form method="POST" action="{{ route('select-role') }}">
            @csrf
            <div class="role-options">
                <label class="role-card">
                    <input type="radio" name="role" value="customer" style="display: none;" required>
                    <img src="{{ asset('images/customer_inactive.png') }}" alt="Customer" class="inactive">
                    <span>Customer</span>
                </label>
                <label class="role-card">
                    <input type="radio" name="role" value="restaurant" style="display: none;" required>
                    <img src="{{ asset('images/restaurant_inactive.png') }}" alt="Restaurant" class="inactive">
                    <span>Restaurant</span>
                </label>
            </div>
            <button type="submit">Select</button>
        </form>
        </div>  
    </div>
    <script>
        document.querySelectorAll('.role-card input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.role-card').forEach(card => {
                    card.classList.remove('active');
                    const img = card.querySelector('img');
                    img.src = img.src.replace('_active', '_inactive');
                    img.classList.remove('active');
                    img.classList.add('inactive');
                });
                const parent = this.parentElement;
                parent.classList.add('active');
                const img = parent.querySelector('img');
                img.src = img.src.replace('_inactive', '_active');
                img.classList.remove('inactive');
                img.classList.add('active');
            });
        });
    </script>
</body>
</html>