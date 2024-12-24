<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;

class LoginController extends Controller
{
    public function signup(Request $request)
    {
        if ($request->getMethod() == "GET") {
            return view('signup');
        } else {
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'age' => 'required|integer',
                'password' => 'required|string|min:4',
            ]);

            $user =  new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->age = $request->age;
            $user->password=bcrypt($request->password);
            $user->save();
            return redirect()->route('index');
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('login');
        }
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->username;
        $password = $request->password;

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->route('index');
        }

        return redirect()->back()->with('error', 'Invalid credentials!');
    }
}
