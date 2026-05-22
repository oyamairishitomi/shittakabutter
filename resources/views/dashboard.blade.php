@extends('layout')

@section('contents')

<h1>シッタカブッター</h1>
<small>シッタカブッターは、会議やビジネス会話でしれっと使われている「いけすかないカタカナ語・専門用語・ビジネス用語」がようわからんときに用語をリアタイで把握、うまいこと話を合わせるためのクレイジーなアイテムです。</small>

<p id="status"></p>
<p>知ったか開始でスタート</p>
<button id="start">知ったか開始</button><br>
<button id="stop">知ったか終了</button>
<form action="/logout" method="post">
  @csrf
  <button type="submit">ログアウト</button>
</form>
<hr>
<h2>用語集</h2>
<div>
<livewire:term-list />
</div>

<script>
  const start = document.getElementById('start')
  const stop = document.getElementById('stop')
  const status = document.getElementById('status')

  let mediaRecorder;
  let audioChunks = []
  
  start.addEventListener('click', async () => {
    status.textContent = 'マイク準備中...'
    const stream = await navigator.mediaDevices.getUserMedia({ audio:true })
    mediaRecorder = new MediaRecorder(stream);
    audioChunks = [];

    mediaRecorder.ondataavailable = (event) =>{

      if (event.data.size > 0) {
        audioChunks.push(event.data)
      }
    }
    mediaRecorder.onstop = () => {
    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' })
    const formData = new FormData();
    formData.append('audio', audioBlob, 'recording.webm');
    
    fetch('{{ url("/transcribe") }}',{
      method: 'POST',
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
      body : formData
      })
        .then(res => res.json())
        .then(data => console.log(data.mean))
        .then(() => {
          (status.textContent = '知ったか終了')
        })
        .then(() => {
          (Livewire.dispatch('termsUpdated'))
        })
      
    };

    status.textContent = '知ったか開始！';
    mediaRecorder.start();
  });

  stop.addEventListener('click', ()=>{ 
  if (mediaRecorder && mediaRecorder.state !== 'inactive') {
    mediaRecorder.stop();
  }
  })
</script>
@endsection