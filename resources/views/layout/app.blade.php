<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>
        Quiz App
    </title>
    <link rel="icon" href="{{ asset('asset/images/favicon1.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('asset/css/index.css') }}">
    <style>
        .body{
            font-family: Arial, sans-serif;
        }
        .top {
            padding: 0px 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: linear-gradient(90deg,#D6D6D6, black);
            border-radius: 8px;
            color: white;
        }

        .navbar .logo a img {
            height: 65px;
            width: auto;
        }

        .navbar .menu a {
            font-size: 18px;
            color: white;
            margin-left: 15px;
            padding: 8px 12px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .navbar .menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
            text-decoration: none;
            border-radius: 5px;
        }

        a {
            text-decoration: none;
            color: white;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar .menu a {
                margin: 10px 0;
            }
        }
    </style>
    @yield('css')
    <title>Document</title>
</head>

<body>
    <div class="top">
        <div class="shadow">
            <div class="navbar">
                <div class="logo">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('asset/images/topicon.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="menu">
                    <a href="{{ route('logout') }}">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    @yield('js')
</body>

</html>
