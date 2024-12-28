<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Quizy
    </title>
    <link rel="icon" href="{{ asset('asset/images/favicon1.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>

        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 350px;
            background: #333;
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #aaa;
        }

        .form-group input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            outline: none;
            color:#fff;
            border-bottom: 1px solid #fff;
            border-radius: 4px;
            background: transparent;
            background-color: #121212;
            font-size: 16px;
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .form-group input:focus {
            color: white;
            background: #555;
            outline: none
        }

        .form-links {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-top: 10px;
        }

        .form-links a {
            color: #ccc;
            text-decoration: none;
        }

        .form-links a:hover {
            color: #fff;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #fff;
            color: #333;
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .signup-link a {
            color: #00aaff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('asset/images/topicon.png') }}" alt="Logo" style="max-width: 100px; background: white; border-radius: 45px">
        </div>
        <h2>Quizy Sign In</h2>
        <form action="{{route('signin')}}" method="POST">
            @csrf
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="form-group">
                <i class="fas fa-birthday-cake"></i>
                <input type="text" name="age" class="form-control" placeholder="Age" required>
            </div>
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">SignIn</button>
        </form>
        <div class="signup-link">
             Have an account? <a href="{{route('login')}}">Login</a>
        </div>
    </div>
</body>

</html>
