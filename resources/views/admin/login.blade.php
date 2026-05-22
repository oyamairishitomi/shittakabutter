@extends('layout')

@section('title', '| admin')

@section('styles')
<style>
  body { display: flex; justify-content: center; align-items: center; }

  .container {
    width: 100%;
    max-width: 390px;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .page-header { display: flex; flex-direction: column; gap: 6px; }

  .page-header h1 {
    font-size: 15px;
    color: #4caf50;
    font-weight: normal;
    letter-spacing: 0.1em;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #1a2e1a;
  }
  .page-header h1::before { content: '> '; color: #2d5a2d; }

  .page-header .sub {
    font-size: 11px;
    color: #2d5a2d;
    letter-spacing: 0.05em;
  }
</style>
@endsection

@section('contents')
<div class="container">

  <div class="page-header">
    <div class="brand-en">shittakabutter</div>
    <div class="brand-ja">シッタカブッター</div>
    <h1>admin login</h1>
    <div class="sub">// 管理者専用ページ</div>
  </div>

  @if($errors->any())
    @foreach($errors->all() as $error)
      <div class="error-msg">{{ $error }}</div>
    @endforeach
  @endif

  <div class="form-area">
    <form action="{{ url('/admin/login') }}" method="post">
      @csrf
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div>
          <label class="form-label">email</label>
          <input class="form-input" type="text" name="email" value="{{ old('email') }}" placeholder="admin@example.com">
        </div>
        <div>
          <label class="form-label">password</label>
          <input class="form-input" type="password" name="password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn-submit">ログイン</button>
      </div>
    </form>
  </div>

</div>
@endsection
