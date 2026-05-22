<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function showLogin(){
        return view('login');
    }

    // ログインリクエスト処理
    public function login(LoginRequest $request){
        $datum = $request->validated();

        if(Auth::attempt($datum) === false){
            return back()
            ->withInput()
            ->withErrors(['auth' => 'emailかパスワードに誤りがあります。',]);
        }

        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    // ログアウトリクエスト処理
    public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        return redirect('login');
    }

    // 登録の表示
    public function showRegister(){
        return view('register.register');
    }

    // 登録のリクエスト処理
    public function register(RegisterRequest $request){
        $datum = $request->validated();
//        $datum['password'] = Hash::make($datum['password']); モデルでハッシュ化しているので不要

        User::create([
            'name' => $datum['name'],
            'email' => $datum['email'],
            'password' => $datum['password'],
        ]);

        $request->session()->flash('front.user_register_success', true);
        //ブレードにフラッシュでフラグを送る

        return redirect('/login');
    }
}
