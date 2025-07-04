<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/kopcv.jpg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/kopcv.jpg') }}">
    @vite('resources/sass/app.scss')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        body {
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            background: linear-gradient(90deg, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            position: relative;
            width: 850px;
            height: 550px;
            background: #fff;
            margin: 20px;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .form-box {
            margin-top: 10%;
            padding: 40px;
            background-color: #fff;
        }

        .form-box h1 {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 24px;
            align-items: center;
            color: #333;
            text-align: center;
        }

        .input-box {
            position: relative;
            margin-bottom: 24px;
        }

        .input-box input {
            padding: 14px 48px 14px 20px;
            background: #f1f3f5;
            border-radius: 12px;
            border: 1.5px solid transparent;
            font-size: 15.5px;
            font-weight: 500;
            color: #333;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .input-box input:focus {
            background: #fff;
            border-color: #7494ec;
            box-shadow: 0 0 0 3px rgba(116, 148, 236, 0.2);
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #999;
            pointer-events: auto;
            z-index: 2;
        }

        .form-control.is-invalid {
            background-image: none !important;
        }

        .input-box input.is-invalid+i {
            color: #dc3545;
        }

        .input-box .invalid-feedback {
            display: block;
            position: absolute;
            bottom: -18px;
            left: 0;
            font-size: 12px;
            color: #dc3545;
        }

        .input-box input:focus+i {
            color: #7494ec;
        }

        .btn-custom {
            background-color: #6c89e6;
            color: #fff;
            height: 48px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #4a69d4;
            color: #fff;
            box-shadow: 0 8px 20px rgba(92, 123, 236, 0.3);
            transform: translateY(-2px);
        }

        .btn-custom:active {
            background-color: #cccccc;
            /* abu-abu */
            color: #333;
            /* teks abu gelap */
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(1px);
        }

        .btn-custom:disabled,
        .btn-custom[disabled] {
            background-color: #cccccc;
            color: #333;
            cursor: not-allowed;
            opacity: 1;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(1px);
        }

        .toggle-box {
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border-radius: 0 150px 150px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            z-index: 0;
            position: relative;
            overflow: hidden;
        }

        .toggle-box::before {
            content: "";
            position: absolute;
            top: -25%;
            left: -25%;
            width: 150%;
            height: 150%;
            background: radial-gradient(circle at 30% 50%,
                    #6a11cb 0%,
                    #7494ec 40%,
                    transparent 80%);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.6;
            animation: floaty 15s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes floaty {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(30px, 20px) rotate(180deg);
            }

            100% {
                transform: translate(0, 0) rotate(360deg);
            }
        }

        @media (max-width: 767.98px) {
            .card-login {
                flex-direction: column;
                height: auto;
                min-height: 65vh;
                /* atau hapus jika ingin benar-benar mengikuti konten */
            }

            .toggle-box {
                width: 100%;
                height: 250px;
                border-radius: 0 0 50px 50px;
                padding: 30px 20px;
                text-align: center;
                position: relative;
                top: -50px;
                /* Naikkan ke atas */
                z-index: 2;
            }

            .toggle-box h1 {
                margin-top: 20%;
            }

            .form-box {
                width: 100%;
                margin-top: -50px;
                /* Biar naik dikit */
                padding: 30px 20px;
                border-radius: 30px;
                background: #fff;
                z-index: 1;
                position: relative;
            }

            .form-box h1,
            .toggle-box h1 {
                font-size: 28px;
            }

            .btn-custom {
                height: 44px;
                font-size: 15px;
            }


        }
    </style>
    @livewireStyles
</head>

<body class="">
    <div class="container h-100 d-flex align-items-center justify-content-center">
        {{ $slot }}
    </div>
</body>
@stack('scripts')
@livewireScripts
@vite('resources/js/app.js')

</html>
