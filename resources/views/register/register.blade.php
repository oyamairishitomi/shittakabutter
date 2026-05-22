@extends('layout')

@section('title', '| register')

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
    font-size: 18px;
    color: #4caf50;
    font-weight: normal;
    letter-spacing: 0.1em;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #1a2e1a;
  }
  .page-header h1::before { content: '> '; color: #2d5a2d; }

  .consent-area {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 12px 14px;
    border: 1px solid #1a2e1a;
    border-radius: 3px;
  }
  .consent-area input[type="checkbox"] {
    margin-top: 2px;
    accent-color: #4caf50;
    flex-shrink: 0;
  }
  .consent-area label {
    font-size: 12px;
    color: #5a8a5a;
    line-height: 1.6;
    font-family: -apple-system, 'Hiragino Sans', sans-serif;
  }

  .sub-link {
    text-align: center;
    font-size: 12px;
    color: #3a5a3a;
  }
  .sub-link a { color: #4caf50; text-decoration: none; }
  .sub-link a:hover { text-decoration: underline; }
</style>
@endsection

@section('contents')
<div class="container">

  <div class="page-header">
    <div class="brand-en">shittakabutter</div>
    <div class="brand-ja">シッタカブッター</div>
    <h1>新規登録</h1>
  </div>

  @if($errors->any())
    @foreach($errors->all() as $error)
      <div class="error-msg">{{ $error }}</div>
    @endforeach
  @endif

  <div class="form-area">
    <form action="{{ url('/register') }}" method="post">
      @csrf
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div>
          <label class="form-label">name</label>
          <input class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="山田 太郎">
        </div>
        <div>
          <label class="form-label">email</label>
          <input class="form-input" type="text" name="email" value="{{ old('email') }}" placeholder="you@example.com">
        </div>
        <div>
          <label class="form-label">password</label>
          <input class="form-input" type="password" name="password" placeholder="••••••••">
        </div>
        <div>
          <label class="form-label">password (確認)</label>
          <input class="form-input" type="password" name="password_confirmation" placeholder="••••••••">
        </div>
        <div class="consent-area">
          <input type="checkbox" name="consent" id="consent">
          <label for="consent">このサービスは音声の取得を行います。使用時は周囲の人の許可を取って使用してください。</label>
        </div>
        <button type="submit" class="btn-submit">登録する</button>
      </div>
    </form>
  </div>

  <div class="sub-link">
    すでにアカウントをお持ちの方は <a href="{{ url('/login') }}">ログイン</a>
  </div>

</div>
@endsection
