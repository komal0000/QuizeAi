<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css"
        integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('asset/css/index.css') }}">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #343a40;
            color: white;
            padding: 10px 20px;
        }

        .navbar .logo {
            font-size: 34px;
            padding: 8px;
            font-weight: bold;
        }

        .navbar .menu ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar .menu ul li {
            margin: 0 10px;
        }

        a {
            text-decoration: none;
            color: white
        }
    </style>
    @yield('css')
    <title>Document</title>
</head>

<body>
    <div class="top">
        <div class="navbar">
            <div class="logo">
                <a href="{{ route('index') }}">
                    Quiz App
                </a>
            </div>
            <div class="menu">
                <ul>
                    <li>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @yield('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('js')
</body>

</html>
