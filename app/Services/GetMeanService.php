<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

// POSTを用いてGPTモデルでプロンプト付きでリクエストをGPTに送る
class GetMeanService{
  public function getMean($text): array{
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    ])->post('https://api.openai.com/v1/chat/completions',[
    'model' => 'gpt-4o',
    'messages' => [
      [
        'role' => 'system',
        // GPT-4oにJSON形式での返却を明示指定する。その後の処理のため
        'content' => '音声ファイルを文書化し、その中から難しいカタカナ語・ビジネス用語・専門用語を抜き出して一言で説明を返してください。その際、[{"name": "用語", "description": "説明"},{ ...}]と用語名・説明を収めたJSON形式で返してください。'
      ],[
        'role' => 'user',
        'content' => $text,
      ],
    ],
    ]);
    // json_decodeがnullを返す場合はOpenAI側のレスポンス形式崩れを疑う
    return json_decode($response->json('choices.0.message.content'), true);
}
}