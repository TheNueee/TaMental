@extends('layouts.app')

@section('title', 'Pengujian DASS-21')

@section('content')
<style>
    .assessment-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(244, 162, 97, 0.05) 0%, rgba(231, 111, 81, 0.05) 100%);
        border-radius: var(--border-radius-lg);
        border: 1px solid rgba(244, 162, 97, 0.1);
    }

    .assessment-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .assessment-subtitle {
        font-size: 1.1rem;
        color: var(--text-light);
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto;
    }

    .assessment-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: linear-gradient(135deg, rgba(244, 162, 97, 0.03) 0%, rgba(231, 111, 81, 0.03) 100%);
    }

    .question-wrapper {
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .progress-header {
        text-align: center;
        margin-bottom: 3rem;
        opacity: 0;
        animation: fadeInUp 0.6s ease forwards;
    }

    .progress-bar-container {
        width: 100%;
        height: 6px;
        background: rgba(244, 162, 97, 0.1);
        border-radius: var(--border-radius-full);
        margin-bottom: 1rem;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        border-radius: var(--border-radius-full);
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        width: 0%;
        position: relative;
    }

    .progress-text {
        font-size: 0.9rem;
        color: var(--text-light);
        font-weight: 500;
    }

    .question-card {
        background: white;
        border-radius: 20px;
        padding: 3rem 2.5rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(244, 162, 97, 0.1);
        text-align: center;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease 0.2s forwards;
    }

    .question-number {
        display: inline-block;
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius-full);
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
    }

    .question-text {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.6;
        margin-bottom: 3rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .options-grid {
        display: grid;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .option-button {
        background: #f8fafc;
        border: 2px solid var(--border-light);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--text-dark);
        text-align: center;
        position: relative;
        overflow: hidden;
        opacity: 0;
        transform: translateY(20px);
    }

    .option-button:nth-child(1) { animation: fadeInUp 0.4s ease 0.4s forwards; }
    .option-button:nth-child(2) { animation: fadeInUp 0.4s ease 0.5s forwards; }
    .option-button:nth-child(3) { animation: fadeInUp 0.4s ease 0.6s forwards; }
    .option-button:nth-child(4) { animation: fadeInUp 0.4s ease 0.7s forwards; }

    .option-button:hover {
        background: rgba(244, 162, 97, 0.05);
        border-color: rgba(244, 162, 97, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(244, 162, 97, 0.15);
    }

    .option-button.selected {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        border-color: var(--primary-orange);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(244, 162, 97, 0.3);
    }

    .option-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .option-button:hover::before {
        left: 100%;
    }

    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        opacity: 0;
        animation: fadeInUp 0.4s ease 0.8s forwards;
    }

    .nav-button {
        background: var(--border-light);
        border: none;
        border-radius: var(--border-radius-full);
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-light);
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 120px;
    }

    .nav-button:hover {
        background: var(--text-light);
        color: white;
        transform: translateY(-2px);
    }

    .nav-button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .nav-button.primary {
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        color: white;
        opacity: 0.6;
        pointer-events: none;
    }

    .nav-button.primary.enabled {
        opacity: 1;
        pointer-events: auto;
    }

    .nav-button.primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(244, 162, 97, 0.4);
    }

    .question-indicator {
        text-align: center;
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .fade-transition {
        opacity: 0;
        transform: translateX(30px);
        transition: all 0.3s ease;
    }

    .fade-transition.active {
        opacity: 1;
        transform: translateX(0);
    }

    .completion-screen {
        text-align: center;
        padding: 3rem 2rem;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .completion-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        font-size: 2rem;
    }

    .completion-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .completion-subtitle {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .assessment-container {
            padding: 1rem;
        }
        
        .question-card {
            padding: 2rem 1.5rem;
        }
        
        .question-text {
            font-size: 1.2rem;
        }
        
        .option-button {
            padding: 1.25rem 1.5rem;
            font-size: 1rem;
        }
        
        .navigation-buttons {
            flex-direction: column;
            gap: 1rem;
        }
        
        .nav-button {
            width: 100%;
        }
    }
</style>


<div class="assessment-container">
    <div class="question-wrapper">
        <!-- Progress Header -->
        <div class="progress-header">
            <div class="progress-bar-container">
                <div class="progress-bar" id="progressBar"></div>
            </div>
            <div class="progress-text" id="progressText">Pertanyaan 1 dari 21</div>

            <p class="assessment-subtitle">
            </br> Silakan jawab setiap pertanyaan dengan jujur sesuai pengalaman Anda.
        </p>
        </div>

        <!-- Question Card -->
        <div class="question-card" id="questionCard">
            <div class="question-number" id="questionNumber">Pertanyaan 1</div>
            <div class="question-text" id="questionText">Loading...</div>
            
            <div class="options-grid" id="optionsGrid">
                <button class="option-button" data-value="0">Tidak pernah sama sekali</button>
                <button class="option-button" data-value="1">Kadang-kadang</button>
                <button class="option-button" data-value="2">Sering</button>
                <button class="option-button" data-value="3">Sangat sering</button>
            </div>

            <div class="navigation-buttons">
                <button class="nav-button" id="prevButton" onclick="previousQuestion()">
                    ← Sebelumnya
                </button>
                <div class="question-indicator" id="questionIndicator">1/21</div>
                <button class="nav-button primary" id="nextButton" onclick="nextQuestion()">
                    Selanjutnya →
                </button>
            </div>
        </div>

        <!-- Completion Screen -->
        <div class="question-card" id="completionScreen" style="display: none;">
            <div class="completion-screen">
                <div class="completion-icon">🎉</div>
                <div class="completion-title">Selesai!</div>
                <div class="completion-subtitle">
                    Terima kasih telah menyelesaikan pengujian DASS-21.<br>
                    Klik tombol di bawah untuk melihat hasil Anda.
                </div>
                <button class="btn-cta2" onclick="submitAssessment()">
                    Lihat Hasil Pengujian
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden form for submission -->
    <form method="POST" action="{{ route('pengujiandass21') }}" id="assessmentForm" style="display: none;">
        @csrf
        <div id="hiddenInputs"></div>
    </form>
</div>

<script>
// Questions data from your controller
const questions = @json(array_values((new App\Http\Controllers\PengujianController())->getPertanyaan()));

// Assessment state
let currentQuestion = 0;
let answers = {};
const totalQuestions = questions.length;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadQuestion();
    updateProgress();
    
    // Add click handlers to option buttons
    document.querySelectorAll('.option-button').forEach(button => {
        button.addEventListener('click', function() {
            selectOption(this.dataset.value);
        });
    });
});

function loadQuestion() {
    const questionText = document.getElementById('questionText');
    const questionNumber = document.getElementById('questionNumber');
    const questionIndicator = document.getElementById('questionIndicator');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    
    // Update question content
    questionText.textContent = questions[currentQuestion];
    questionNumber.textContent = `Pertanyaan ${currentQuestion + 1}`;
    questionIndicator.textContent = `${currentQuestion + 1}/${totalQuestions}`;
    
    // Update navigation buttons
    prevButton.disabled = currentQuestion === 0;
    
    // Update next button text
    if (currentQuestion === totalQuestions - 1) {
        nextButton.textContent = 'Selesai ✓';
    } else {
        nextButton.textContent = 'Selanjutnya →';
    }
    
    // Restore selected answer if exists
    clearOptionSelection();
    if (answers[currentQuestion] !== undefined) {
        selectOption(answers[currentQuestion], false);
        enableNextButton();
    } else {
        disableNextButton();
    }
}

function selectOption(value, animate = true) {
    // Clear previous selection
    document.querySelectorAll('.option-button').forEach(btn => {
        btn.classList.remove('selected');
    });
    
    // Select clicked option
    const selectedButton = document.querySelector(`[data-value="${value}"]`);
    selectedButton.classList.add('selected');
    
    // Store answer
    answers[currentQuestion] = parseInt(value);
    
    // Enable next button
    enableNextButton();
}

function clearOptionSelection() {
    document.querySelectorAll('.option-button').forEach(btn => {
        btn.classList.remove('selected');
    });
}

function enableNextButton() {
    const nextButton = document.getElementById('nextButton');
    nextButton.classList.add('enabled');
}

function disableNextButton() {
    const nextButton = document.getElementById('nextButton');
    nextButton.classList.remove('enabled');
}

function nextQuestion() {
    if (answers[currentQuestion] === undefined) return;
    
    if (currentQuestion < totalQuestions - 1) {
        currentQuestion++;
        transitionToQuestion();
    } else {
        showCompletionScreen();
    }
}

function previousQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        transitionToQuestion();
    }
}

function transitionToQuestion() {
    const questionCard = document.getElementById('questionCard');
    
    // Fade out
    questionCard.style.opacity = '0';
    questionCard.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        loadQuestion();
        updateProgress();
        
        // Fade in
        questionCard.style.opacity = '1';
        questionCard.style.transform = 'translateY(0)';
    }, 200);
}

function updateProgress() {
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    const progress = ((currentQuestion + 1) / totalQuestions) * 100;
    progressBar.style.width = progress + '%';
    progressText.textContent = `Pertanyaan ${currentQuestion + 1} dari ${totalQuestions}`;
}

function showCompletionScreen() {
    const questionCard = document.getElementById('questionCard');
    const completionScreen = document.getElementById('completionScreen');
    
    // Hide question card
    questionCard.style.display = 'none';
    
    // Show completion screen
    completionScreen.style.display = 'block';
    
    // Update progress to 100%
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    progressBar.style.width = '100%';
    progressText.textContent = 'Pengujian Selesai ✓';
}

function submitAssessment() {
    // Create hidden form inputs
    const hiddenInputs = document.getElementById('hiddenInputs');
    hiddenInputs.innerHTML = '';
    
    for (let i = 0; i < totalQuestions; i++) {
        if (answers[i] !== undefined) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `jawaban[${i}]`;
            input.value = answers[i];
            hiddenInputs.appendChild(input);
        }
    }
    
    // Submit form
    document.getElementById('assessmentForm').submit();
}
</script>
@endsection