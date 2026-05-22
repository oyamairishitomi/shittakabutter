@extends('layout')

@section('contents')
<h1>ユーザー管理</h1>
<form action="{{ url('/admin/logout') }}" method="POST">
  @csrf
  <button>ログアウト</button>
</form>

<table border="1">
  <tr>
    <th>ID</th>
    <th>名前</th>
    <th>メールアドレス</th>
    <th>登録日時</th>
  </tr>
  @foreach($users as $user)
  <tr>
    <td>{{ $user->id }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->created_at }}</td>
  </tr>
  @endforeach
</table>
@endsection