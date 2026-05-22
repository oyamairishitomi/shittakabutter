<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GetWordService
{
    // 音声ファイルを受け取ってWhisper APIで文字起こしし、テキストを返すメソッド
    public function transcribe($file): string
    {
        // OpenAI APIへのHTTPリクエストを組み立てる
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'), // .envからAPIキーを読み込んでヘッダーにセット
        ])->attach(
            'file',                                  // APIが受け取るフィールド名
            file_get_contents($file->getRealPath()), // 音声ファイルをバイナリで読み込む
            'audio.webm'                             // ファイル名（形式をAPIに伝える）
        )->post('https://api.openai.com/v1/audio/transcriptions', [
            'model' => 'whisper-1', // 使用するWhisperモデル
            'language' => 'ja',     // 日本語として文字起こし
        ]);

        return $response->json('text'); // APIレスポンスのJSONから文字起こし結果を取り出して返す
    }
}
