<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\AdminLoginRequest;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        if (!Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'メールアドレスまたはパスワードが違います']);
        }
        return redirect('/admin/users');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }
}