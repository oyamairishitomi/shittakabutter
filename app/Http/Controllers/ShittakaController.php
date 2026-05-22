<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Requests\WhisperRequest;
use App\Services\GetWordService;
use App\Services\GetMeanService;

class ShittakaController extends Controller
{
    public function dashboard(){ 
    //     //用語集
    //     $terms = Term::where('user_id',Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);　コメントアウトした理由→Livewireにお引越ししたから
        return view('dashboard');
    }

    public function transcribe(WhisperRequest $request) {
        $file = $request->file('audio');
        $text = (new GetWordService)->transcribe($file);
        $mean = (new GetMeanService)->getMean($text);

        $user_id = Auth::id();

        // 抽出された用語を1件ずつ保存（1回の録音で複数用語が返る）
        foreach($mean as $term){
        Term::create([
            'user_id' => $user_id,
           'name' =>$term['name'],
            'description' => $term['description'],
        ]);
        }
        return response()->json(['mean' => $mean]);
    }

    public function destroy(Request $request, $id){
        $term = Term::findOrFail($id);
        // 他ユーザーの用語を削除できないよう所有者を確認
        if (auth()->id() !== $term->user_id) abort(403);
        $term->delete();
        return redirect('/dashboard');
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect(route('login'));
    }
}