<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kasir Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #f7ede2 50%, #4b2e2e 50%);
        }

        .container {
            display: flex;
            width: 750px;
            height: 480px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .left,
        .right {
        flex: 1; 
        }

        .left {
        flex: 1;
        background: url("{{ asset('images/kopidratas.jpg') }}") no-repeat center center;
        background-size: cover; 
    }

        .right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            background: #fff;
        }

        .right h2 {
            font-size: 24px;
            color: #4b2e2e;
            margin-bottom: 25px;
            text-align: center;
        }

        form {
            width: 100%;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: #4b2e2e;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #c97c5d;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6f4e37;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 5px;
            transition: background 0.3s;
        }

        button:hover {
            background: #4b2e2e;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Left pakai background aja -->
        <div class="left"></div>

        <!-- Right form login -->
        <div class="right">
            <h2>Welcome Back</h2>

            @if(session('error'))
            <p class="error">{{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

                <button type="submit">Login</button>
            </form>

            <p class="footer-text">© 2025 K4Grafika Cafe</p>
        </div>
    </div>
</body>

</html>
