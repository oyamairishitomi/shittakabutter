# シッタカブッター

**https://shittaka.1103.horse**
※テスト　kouji@kouji.com / pass: koujikouji

会議やビジネス会話で飛び交うカタカナ語・専門用語をリアルタイムで文字起こし・解説するWebアプリ。

## 概要

「アジェンダ」「オンボーディング」「KPI」——会議中に知らない用語が出ても聞き返せない場面はよくある。  
シッタカブッターは、その場で録音してAPIに投げるだけで、わからなかった用語を一覧で把握できるツール。

## 機能

- **音声録音・文字起こし** — ブラウザからワンクリック録音、OpenAI Whisper APIで日本語文字起こし
- **用語抽出・解説** — GPT-4oが文字起こし結果からカタカナ語・ビジネス用語を自動抽出し、一言解説を生成
- **用語集のリアルタイム更新** — Livewireにより、ページリロードなしで用語カードを追加表示
- **用語削除・ページネーション** — 用語ごとの削除、10件ごとのページング
- **ユーザー認証** — 会員登録・ログイン・ログアウト（Laravel Breeze相当の独自実装）
- **管理者機能** — 管理者ログイン・ユーザー一覧の閲覧

## 技術スタック

| カテゴリ | 技術 |
|---|---|
| バックエンド | PHP 8 / Laravel 11 |
| フロントエンド | Livewire v4（リアルタイムUI更新） |
| データベース | SQLite |
| 外部API | OpenAI Whisper API（音声→テキスト）、GPT-4o（用語抽出） |
| 認証 | Laravel 標準認証（独自実装） |

## 工夫した点

- **責務の分離** — 音声取得（`GetWordService`）・用語抽出（`GetMeanService`）をサービスクラスに切り出し、コントローラーをシンプルに保った
- **Livewireによるリアクティブ更新** — `#[Computed]` で用語一覧を管理し、`#[On('termsUpdated')]` でJS側からのイベントを受け取って再描画。ページ全体のリロードを排除した
- **セキュリティ** — 認証ミドルウェアによるルート保護、用語削除時の所有者チェック（他ユーザーの用語を削除できない）

## ローカル環境での起動

```bash
git clone https://github.com/oyamairishitomi/shittakabutter.git
cd shittakabutter
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

`.env` に OpenAI APIキーを設定：

```
OPENAI_API_KEY=your_api_key_here
```

```bash
php artisan serve
```

## 画面イメージ

| 機能 | 説明 |
|---|---|
| ダッシュボード | 録音開始/終了ボタン、用語集一覧 |
| 録音→解析 | 停止後にWhisper→GPT-4oが走り、用語カードが自動追加 |
| 管理画面 | `/admin/login` から管理者としてユーザー一覧を確認可能 |
