@extends('layouts.app')

@section('title', 'Pengujian DASS-21')

@section('content')
<h1>@yield('title')</h1>
<style>
    .progress-container {
        position: sticky;
        top: 0;
        background: white;
        z-index: 100;
        padding: 1rem 0;
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981, #059669);
        border-radius: 4px;
        transition: width 0.3s ease;
        width: 0%;
    }

    .btn.ready {
        background-color: #10b981;
        border-color: #10b981;
    }
</style>

<p>Silakan isi kuesioner di bawah ini sesuai dengan apa yang Anda rasakan selama seminggu terakhir.</p>

<div class="progress-container">
    <div class="flex justify-between items-center mb-2">
        <span class="text-sm font-medium text-gray-600">Progress Pengisian</span>
        <span class="text-sm font-medium text-gray-600" id="progress-text">0/21 dijawab</span>
    </div>
    <div class="progress-bar">
        <div class="progress-fill" id="progress-fill"></div>
    </div>
    <div class="mt-2 text-sm" id="completion-text">Masih 21 pertanyaan lagi</div>
</div>

<form method="POST" action="{{ route('pengujiandass21') }}">
    @csrf
    @foreach ($pertanyaan as $index => $teks)
        <div class="form-group mb-4 question-card">
            <label class="fw-bold">{{ $index + 1 }}. {{ $teks }}</label><br>
            @foreach ([0 => 'Tidak pernah sama sekali', 1 => 'Kadang-kadang', 2 => 'Sering', 3 => 'Sangat sering'] as $value => $label)
                <div class="form-check">
                    <input type="radio" name="jawaban[{{ $index }}]" value="{{ $value }}" class="form-check-input">
                    <label class="form-check-label">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="form-group mt-4">
        <button type="submit" class="btn btn-success btn-lg" id="submit-btn">Lihat Hasil</button>
    </div>
</form>

<script>
function updateProgress() {
    const totalQuestions = 21;
    const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
    const progressPercentage = (answeredQuestions / totalQuestions) * 100;

    document.getElementById('progress-fill').style.width = progressPercentage + '%';
    document.getElementById('progress-text').textContent = answeredQuestions + '/' + totalQuestions + ' dijawab';

    // Update submit button & completion text
    const submitBtn = document.getElementById('submit-btn');
    const completionText = document.getElementById('completion-text');

    if (answeredQuestions === totalQuestions) {
        submitBtn.classList.add('ready');
        completionText.textContent = 'Siap untuk melihat hasil! 🎉';
        completionText.style.color = '#10b981';
    } else {
        submitBtn.classList.remove('ready');
        completionText.textContent = `Masih ${totalQuestions - answeredQuestions} pertanyaan lagi`;
        completionText.style.color = '#6b7280';
    }
}

// Pasang event listener ke semua radio input
document.querySelectorAll('input[type="radio"]').forEach((radio) => {
    radio.addEventListener('change', updateProgress);
});
</script>
@endsection
