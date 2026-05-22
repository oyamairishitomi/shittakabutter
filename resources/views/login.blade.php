@extends('layout')

@section('contents')
@if($errors->any())
  @foreach($errors->all() as $error)
  {{ $error }}<br>
  @endforeach
@endif
@if(session('front.user_register_success') == true)
  登録完了しました。
@endif
  <h1>ログイン</h1>
  <form action="{{ url('/login') }}" method="post">
    @csrf
    email：<input type="text" name="email"><br>
    パスワード：<input type="password" name="password"><br>
    <button>ログインする</button>
  </form>
  <a href="user/register">会員登録</a>
@endsection