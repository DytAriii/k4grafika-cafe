<!DOCTYPE html>
<html lang="id">

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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #f5e6da, #f2d0a7);
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 850px;
            min-height: 500px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.2);
            background: #fff;
        }

        .left,
        .right {
            flex: 1;
        }

        .left {
            background: url("{{ asset('images/logok4cafe.png') }}") no-repeat center center;
            background-size: cover;
        }

        .right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px 40px;
            background: #fff;
        }

        .right h2 {
            font-size: 26px;
            color: #A74C29;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        form {
            width: 100%;
        }

        label {
            font-size: 14px;
            font-weight: 500;
            color: #A74C29;
            margin-bottom: 6px;
            display: block;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #A74C29;
            background: #fff;
            box-shadow: 0 0 0 2px rgba(167, 76, 41, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #A74C29;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 5px;
            transition: all 0.3s;
        }

        button:hover {
            background: #8C3E22;
            transform: translateY(-2px);
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13px;
        }

        .footer-text {
            margin-top: 25px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }

        /* ================= Responsive ================= */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 420px;
                min-height: auto;
            }

            .left {
                display: none;
            }

            .right {
                padding: 35px 25px;
            }

            .right h2 {
                font-size: 22px;
                margin-bottom: 25px;
            }
        }

        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                border-radius: 14px;
            }

            .right {
                padding: 25px 20px;
            }

            input,
            button {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Kiri (gambar kopi) -->
        <div class="left"></div>

        <!-- Kanan (form login) -->
        <div class="right">
            <h2>Selamat Datang Kembali</h2>

            @if(session('error'))
            <p class="error">{{ session('error') }}</p>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <label for="username">Nama Pengguna</label>
                <input type="text" id="username" name="username" placeholder="Masukkan nama pengguna" required>

                <label for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" placeholder="Masukkan kata sandi" required>

                <button type="submit">Masuk</button>
            </form>

            <p class="footer-text">© 2025 Café K4Grafika</p>
        </div>
    </div>
</body>

</html>