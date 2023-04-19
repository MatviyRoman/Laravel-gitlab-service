<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index() {
        // Отримаємо інформацію про користувача з сесії
        $user = Session::get('user');

        // перевіряємо що зміна не порожня
        if(isset($user)) {
            // записуємо в зміну аватар користувача
            $avatar = $user->avatar;

            // записуємо в зміну ім'я користувача
            $name = $user->name;

            // Отримуємо репозиторії користувача
            $repositories = Http::withHeaders([
            ])->get('https://gitlab.com/api/v4/users/' . $user->id . '/projects')->json();

            // Повернення відображення зі списком репозиторіїв користувача, його аватаром та ім'ям
            return view('welcome', compact('user', 'avatar', 'name', 'repositories'));
        }

        return view('welcome');
    }
}
