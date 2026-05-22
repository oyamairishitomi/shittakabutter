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
  <style>
    .terms-list { display: flex; flex-direction: column; gap: 8px; }

    .card {
      background: #0a0f0a;
      border: 1px solid #1a2e1a;
      border-left: 3px solid #2d5a2d;
      border-radius: 2px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .card:hover { border-left-color: #4caf50; }

    .card-name {
      font-size: 15px;
      font-weight: bold;
      color: #88d488;
      letter-spacing: 0.05em;
    }
    .card-name::before { content: '['; color: #2d5a2d; }
    .card-name::after  { content: ']'; color: #2d5a2d; }

    .card-desc {
      font-size: 14px;
      color: #7aaa7a;
      line-height: 1.7;
      font-family: -apple-system, 'Hiragino Sans', sans-serif;
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 2px;
    }

    .card-date { font-size: 11px; color: #3a5a3a; }

    .card-delete {
      font-size: 11px;
      color: #3a5a3a;
      background: none;
      border: none;
      cursor: pointer;
      font-family: 'Courier New', monospace;
      letter-spacing: 0.05em;
    }
    .card-delete:hover { color: #ef4444; }

    .pagination {
      display: flex;
      justify-content: center;
      gap: 24px;
      padding: 8px 0 16px;
      font-size: 12px;
      font-family: 'Courier New', monospace;
    }
    .pagination a { color: #2d5a2d; text-decoration: none; }
    .pagination a:hover { color: #4caf50; }
  </style>

  <div class="terms-list">
    @foreach($this->terms as $term)
    <div class="card">
      <div class="card-name">{{ $term->name }}</div>
      <div class="card-desc">{{ $term->description }}</div>
      <div class="card-footer">
        <span class="card-date">{{ $term->created_at }}</span>
        <form action="{{ url('/delete') }}/{{ $term->id }}" method="POST" style="margin:0;">
          @method('DELETE')
          @csrf
          <button type="submit" class="card-delete">delete</button>
        </form>
      </div>
    </div>
    @endforeach
  </div>

  <div class="pagination">
    @if($this->terms->previousPageUrl())
      <a href="{{ $this->terms->previousPageUrl() }}">« prev</a>
    @endif
    @if($this->terms->nextPageUrl())
      <a href="{{ $this->terms->nextPageUrl() }}">next »</a>
    @endif
  </div>
</div>