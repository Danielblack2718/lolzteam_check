<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Проверка запроса
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Поиск пользователя с логином
        $admin = Admin::where('login', $request->login)->first();

        if (!$admin || !Hash::check($request->password, $admin->pass)) {
            // Если админ не найден или пароль не верен, возвращаем ошибку
            return response(['message' => 'Invalid login or password'], 401);
        }

        // Если админ найден и пароль верен, возвращаем admin_key
        return response(['admin_key' => $admin->admin_key]);
    }
    public function register(Request $request)
    {
        // Проверка запроса
        $request->validate([
            'login' => 'required|unique:admins',
            'password' => 'required',
            'admin_key' => 'required',
        ]);

        // Хеширование пароля перед сохранением в базе данных
        $hashedPassword = Hash::make($request->password);

        // Создание нового администратора
        $admin = new Admin;
        $admin->login = $request->login;
        $admin->pass = $hashedPassword;
        $admin->admin_key = $request->admin_key;
        $admin->save();

        // Возвращение созданного администратора
        return response($admin, 201);
    }
}
