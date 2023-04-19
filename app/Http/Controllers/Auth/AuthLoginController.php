<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class AuthLoginController extends Controller
{
    public function redirectToProvider()
    {
        // Редірект на сторінку gitlab для авторизації
        return Socialite::driver('gitlab')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        // Отримання даних про користувача
        $user = Socialite::driver('gitlab')->user();

        // Збереження даних користувача в сесію
        Session::put('user', $user);

        // Перенаправлення на головну сторінку
        return redirect('/');
    }

    public function logout(Request $request)
    {
        // викликаємо метод forget() на об'єкті сесії для видалення даних користувача
        $request->session()->forget('user');

        // редірект на головну сторінку
        return redirect('/');
    }
}
