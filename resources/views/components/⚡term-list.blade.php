<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithPagination;
    #[Computed]
    public function terms(){
         $terms = Term::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);

    return $terms;
    }

    #[On('termsUpdated')]
    public function refresh(){

    }
};
?>

<div>
    @foreach($this->terms as $term)
    <h2>{{ $term->name }}</h2>
    <p>{{ $term->description }}</p>
    <form action="{{ url('/delete') }}/{{ $term->id }}" method="POST">
    @method('DELETE')
    @csrf
    <button type="submit">削除する</button>
    </form>
    <small>{{ $term->created_at }}</small>
    @endforeach
<div>
    @if($this->terms->previousPageUrl())
        <a href="{{ $this->terms->previousPageUrl() }}">« 前へ</a>
    @endif
    @if($this->terms->nextPageUrl())
        <a href="{{ $this->terms->nextPageUrl() }}">次へ »</a>
    @endif
</div>
</div>