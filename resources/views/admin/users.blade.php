@extends('layout')

@section('title', '| admin/users')

@section('styles')
<style>
  body { padding: 24px; }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #1a2e1a;
    padding-bottom: 14px;
    margin-bottom: 24px;
  }

  .brand { display: flex; flex-direction: column; gap: 3px; }

  .table-label {
    font-size: 11px;
    color: #4caf50;
    letter-spacing: 0.1em;
    margin-bottom: 12px;
  }
  .table-label::before { content: '// '; }

  .table-wrap { overflow-x: auto; }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  thead tr { border-bottom: 1px solid #2d5a2d; }

  th {
    text-align: left;
    padding: 10px 14px;
    font-weight: normal;
    color: #4caf50;
    letter-spacing: 0.08em;
    white-space: nowrap;
  }
  th::before { content: '# '; color: #2d5a2d; font-size: 10px; }

  td {
    padding: 12px 14px;
    color: #7aaa7a;
    border-bottom: 1px solid #0f150f;
    white-space: nowrap;
  }

  tr:hover td { background: #0a0f0a; }

  .id-cell { color: #3a5a3a; font-size: 12px; }
  .date-cell { color: #3a5a3a; font-size: 11px; }

  .count {
    margin-top: 16px;
    font-size: 11px;
    color: #2d5a2d;
  }
  .count::before { content: '> '; }
</style>
@endsection

@section('contents')

<div class="header">
  <div class="brand">
    <div class="brand-en">shittakabutter</div>
    <div class="brand-ja">シッタカブッター</div>
  </div>
  <form action="{{ url('/admin/logout') }}" method="POST" style="margin:0;">
    @csrf
    <button type="submit" class="logout-btn">logout</button>
  </form>
</div>

<div class="table-label">ユーザー一覧</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>名前</th>
        <th>メールアドレス</th>
        <th>登録日時</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td class="id-cell">{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td class="date-cell">{{ $user->created_at }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="count">{{ count($users) }} users found.</div>

@endsection
