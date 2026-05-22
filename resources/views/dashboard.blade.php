@extends('layout')

@section('title', '| dashboard')

@section('styles')
<style>
  body { display: flex; justify-content: center; }

  .container {
    width: 100%;
    max-width: 390px;
    padding: 20px 16px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    border-bottom: 1px solid #1a2e1a;
    padding-bottom: 12px;
  }

  .header h1 {
    font-size: 15px;
    font-weight: normal;
    color: #4caf50;
    letter-spacing: 0.1em;
  }
  .header h1::before { content: '> '; color: #2d5a2d; }

  .status-area {
    border: 1px solid #1a2e1a;
    border-radius: 4px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    background: #0a0f0a;
  }

  .status-line {
    font-size: 14px;
    color: #4caf50;
    min-height: 18px;
  }
  .status-line.active { color: #ef4444; }

  .cursor {
    display: inline-block;
    width: 8px;
    height: 13px;
    background: #4caf50;
    vertical-align: middle;
    margin-left: 2px;
    animation: blink 1s step-end infinite;
  }

  @keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
  }

  .btn-group { display: flex; flex-direction: column; gap: 8px; }

  .btn {
    width: 100%;
    padding: 16px 18px;
    border-radius: 3px;
    border: 1px solid #1a2e1a;
    font-size: 16px;
    font-family: 'Courier New', 'Osaka-Mono', monospace;
    cursor: pointer;
    letter-spacing: 0.08em;
    text-align: left;
    transition: background 0.1s;
  }
  .btn::before { content: '$ '; color: #2d5a2d; }

  .btn-start {
    background: #0d1a0d;
    color: #4caf50;
    border-color: #2d5a2d;
  }
  .btn-start:hover { background: #111f11; }

  .btn-stop {
    background: #0a0f0a;
    color: #4a7a4a;
  }

  .terms-label {
    font-size: 13px;
    color: #4caf50;
    letter-spacing: 0.1em;
  }
  .terms-label::before { content: '// '; }
</style>
@endsection

@section('contents')
<div class="container">

  <div class="header">
    <h1>shittakabutter</h1>
    <form action="/logout" method="post" style="margin:0;">
      @csrf
      <button type="submit" class="logout-btn">logout</button>
    </form>
  </div>

  <div class="status-area">
    <div class="status-line" id="statusLine">
      ready<span class="cursor"></span>
    </div>
    <div class="btn-group">
      <button id="start" class="btn btn-start">知ったか開始</button>
      <button id="stop" class="btn btn-stop">知ったか終了</button>
    </div>
  </div>

  <div class="terms-label">用語集</div>

  <livewire:term-list />

</div>

<script>
  const start = document.getElementById('start');
  const stop  = document.getElementById('stop');

  let mediaRecorder;
  let audioChunks = [];

  start.addEventListener('click', async () => {
    const s = document.getElementById('statusLine');
    s.classList.add('active');
    s.innerHTML = 'recording...<span class="cursor" style="background:#ef4444"></span>';

    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(stream);
    audioChunks = [];

    mediaRecorder.ondataavailable = (event) => {
      if (event.data.size > 0) audioChunks.push(event.data);
    };

    mediaRecorder.onstop = () => {
      s.classList.remove('active');
      s.innerHTML = 'analyzing...<span class="cursor"></span>';

      const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
      const formData = new FormData();
      formData.append('audio', audioBlob, 'recording.webm');

      fetch('{{ url("/transcribe") }}', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        },
        body: formData,
      })
        .then(res => res.json())
        .then(data => console.log(data.mean))
        .then(() => {
          s.innerHTML = 'done. ready<span class="cursor"></span>';
          Livewire.dispatch('termsUpdated');
        });
    };

    mediaRecorder.start();
  });

  stop.addEventListener('click', () => {
    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
      mediaRecorder.stop();
    }
  });
</script>
@endsection
