<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | RAPI-Sekolah</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 16px;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #243047;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            color: #234e91;
            font-size: 26px;
            text-align: center;
        }

        .description {
            color: #64748b;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 25px;
        }

        hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
            background: white;
            color: #243047;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        .button {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 12px 18px;
            font-size: 15px;
            text-decoration: none;
            cursor: pointer;
            text-align: center;
        }

        .button-primary {
            background: #2563eb;
            color: white;
            width: 100%;
        }

        .button-primary:hover {
            background: #1d4ed8;
        }

        .button-secondary {
            background: #e2e8f0;
            color: #243047;
            width: 100%;
            margin-top: 12px;
        }

        .button-secondary:hover {
            background: #cbd5e1;
        }

        .alert {
            padding: 12px 15px;
            margin: 16px 0;
            border-radius: 7px;
            line-height: 1.5;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 22px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px 10px;
            }

            .container {
                padding: 24px 18px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>RAPI-Sekolah</h1>

        <p class="description">
            Sistem Informasi Peminjaman dan Pengelolaan Ruang Sekolah.
            Silakan login untuk melanjutkan.
        </p>

        <hr>

        {{-- Pesan error --}}
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Pesan peringatan --}}
        @if (session('warning'))
            <div class="alert alert-error" role="alert">
                {{ session('warning') }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    placeholder="Masukkan username"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="button button-primary">
                Login
            </button>
        </form>

        <a href="{{ url('/calendar') }}" class="button button-secondary">
            Lihat Kalender Agenda Sekolah (Tamu)
        </a>

        <div class="footer">
            RAPI-Sekolah &copy; {{ date('Y') }}
        </div>

    </div>

</body>
</html>