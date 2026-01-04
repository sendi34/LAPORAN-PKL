<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            height: 100vh;
            background: #00F9FF;
        }

        .login-wrapper {
            max-width: 900px;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
        }

        .left-side {
            background: linear-gradient(135deg, #0d6efd, #3d8bfd);
            color: white;
        }

        .left-side img {
            width: 80%;
        }

        .input-icon {
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            position: absolute;
            color: #6c757d;
        }

        .form-control {
            padding-left: 40px;
            border-radius: 10px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="login-wrapper row">

        <!-- LEFT IMAGE / WELCOME -->
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-4 left-side">
            <h2 class="fw-bold mb-3">Selamat Datang</h2>
            <p class="opacity-75 mb-4 text-center">
                Silakan masuk untuk mengakses dashboard sistem.
            </p>

            <!-- GANTI DENGAN GAMBAR ANDA -->
            <img src="{{ asset('assets/logo-dlh.png') }}" style="width:170px; height:auto;" alt="Login Illustration">
        </div>

        <!-- RIGHT FORM -->
        <div class="col-md-6 p-5">

            <h4 class="fw-bold mb-3">Login Sistem</h4>
            <p class="text-muted mb-4">Masukkan email dan password Anda.</p>

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <!-- EMAIL -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" name="email" class="form-control" placeholder="Alamat Email" required
                        value="{{ old('email') }}">
                </div>

                <!-- PASSWORD -->
                <div class="mb-3 position-relative">
                    <i class="bi bi-lock-fill input-icon"></i>

                    <input type="password" name="password" id="passwordInput" class="form-control"
                        placeholder="Password" required>

                    <i class="bi bi-eye-fill toggle-password" id="togglePassword"></i>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary w-50 py-2 rounded-3 mt-2">
                        Masuk
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("passwordInput");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            togglePassword.classList.toggle("bi-eye-fill");
            togglePassword.classList.toggle("bi-eye-slash-fill");
        });
    </script>

</body>

</html>
