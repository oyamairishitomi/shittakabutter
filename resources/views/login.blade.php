@extends('layout')

@section('title', '| login')

@section('styles')
<style>
  body { display: flex; justify-content: center; align-items: center; }

  .container {
    width: 100%;
    max-width: 390px;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    gap: 28px;
  }

  .brand { display: flex; flex-direction: column; gap: 10px; }

  .brand-desc {
    font-size: 13px;
    color: #4a7a4a;
    line-height: 1.8;
    border-left: 2px solid #1a2e1a;
    padding-left: 12px;
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

  <div class="brand">
    <div class="brand-en">shittakabutter</div>
    <div class="brand-ja">シッタカブッター</div>
    <div class="brand-desc">
      会議中にこっそり使える、カタカナ語・専門用語の即席解説ツール。<br>
      録音するだけで、AIがわからない用語を自動で拾って一言で説明。<br>
      知ったかぶりを、もっとスマートに。
    </div>
  </div>

  @if($errors->any())
    @foreach($errors->all() as $error)
      <div class="error-msg">{{ $error }}</div>
    @endforeach
  @endif

  @if(session('front.user_register_success'))
    <div class="success-msg">登録完了しました。ログインしてください。</div>
  @endif

  <div class="form-area">
    <form action="{{ url('/login') }}" method="post">
      @csrf
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div>
          <label class="form-label">email</label>
          <input class="form-input" type="text" name="email" value="{{ old('email') }}" placeholder="you@example.com">
        </div>
        <div>
          <label class="form-label">password</label>
          <input class="form-input" type="password" name="password" placeholder="••••••••">
        </div>
        <button type="submit" class="btn-submit">ログインする</button>
      </div>
    </form>
  </div>

  <div class="sub-link">
    アカウントをお持ちでない方は <a href="{{ url('/register') }}">会員登録</a>
  </div>

</div>
@endsection
