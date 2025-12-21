<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function processSignOut(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showSignIn()
    {
        return inertia()->render('Auth/SignIn');
    }

    public function processSignIn(SignInRequest $signInRequest)
    {
        $credential = $signInRequest->safe()->only('username', 'password');
        $rememberMe = $signInRequest->safe()->input('rememberMe', false);

        if (! Auth::attempt($credential, $rememberMe)) {
            return back()->withErrors(['auth' => 'Username or password is wrong.']);
        }

        return redirect()->intended('home');
    }

    public function showSignUp()
    {
        return inertia()->render('Auth/SignUp');
    }

    public function processSignUp(SignUpRequest $signUpRequest)
    {
        $validated = $signUpRequest->safe()->only(['username', 'password']);

        User::create($validated);

        return redirect()->route('login');
    }
}
