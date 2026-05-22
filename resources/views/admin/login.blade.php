@extends('layout')

@section('contents')
@if($errors->any())
  @foreach($errors->all() as $error)
    {{ $error }}<br>
  @endforeach
@endif
<h1>管理者ログイン</h1>
<form action="{{ url('/admin/login') }}" method="POST">
  @csrf
  email：<input type="text" name="email"><br>
  パスワード：<input type="password" name="password"><br>
  <button>ログイン</button>
</form>
@endsection