@extends('layout')

@section('contents')

@if(front.user_register_success === true)
  <p>登録完了しました。以下よりログインしてください。</p>
@endif
@if($errors->any())
@foreach($errors->all() as error)
  {{ $error }}<br>
@endforeach
@endif

<h1>ログイン</h1>
  <form action="/login" method="post">
    @csrf
    email：<input type="text" name="email"><br>
    パスワード：<input type="password" name="password"><br>
    <button>ログインする</button>
  </form>
  <a href="user/register">会員登録</a>
@endsection