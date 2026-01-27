@extends('layouts.app')

@section('title', 'Test d\'orientation - UniLomé')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $test->titre }}</h1>
                    <p class="text-gray-600 mt-2">{{ $test->description }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Question</div>
                    <div class="text-2xl font-bold text-blue-600">
                        <span id="question-actuelle">1</span>/{{ $test->nombre_questions }}
                    </div>
                </div>
            </div>
            
            <!-- Barre de progression -->
            <div class="h-2 bg-gray-200 rounded-full mb-8">
                <div id="progress-bar" class="h-full bg-blue-600 rounded-full" style="width: 5%"></div>
            </div>
        </div>
        
        <!-- Formulaire du test -->
        <form id="test-form" action="{{ route('test-orientation.store', $test) }}" method="POST">
            @csrf
            
            @foreach($questions as $index => $question)
            <div class="question-step {{ $index === 0 ? 'active' : 'hidden' }}" data-step="{{ $index + 1 }}">
                <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        {{ $question->texte }}
                    </h2>
                    
                    <div class="space-y-4">
                        @foreach($question->reponses as $reponse)
                        <label class="block">
                            <input type="radio" 
                                   name="reponses[{{ $question->id }}]" 
                                   value="{{ $reponse->id }}"
                                   class="hidden peer">
                            <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition duration-200">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center mr-4">
                                        <div class="w-2 h-2 rounded-full bg-white peer-checked:block hidden"></div>
                                    </div>
                                    <span class="text-lg">{{ $reponse->texte }}</span>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Navigation -->
                <div class="flex justify-between">
                    <button type="button" 
                            onclick="previousQuestion()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 {{ $index === 0 ? 'invisible' : '' }}">
                        <i class="fas fa-arrow-left mr-2"></i>Précédent
                    </button>
                    
                    @if($index === count($questions) - 1)
                    <button type="submit" 
                            class="submit-btn px-8 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-check-circle mr-2"></i>Terminer le test
                    </button>
                    @else
                    <button type="button" 
                            onclick="nextQuestion()"
                            class="next-btn px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        Suivant <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </form>
    </div>
</div>

<script>
let currentStep = 1;
const totalSteps = {{ $test->nombre_questions }};

function updateProgress() {
    const percentage = (currentStep / totalSteps) * 100;
    document.getElementById('progress-bar').style.width = `${percentage}%`;
    document.getElementById('question-actuelle').textContent = currentStep;
}

function isCurrentQuestionAnswered() {
    const currentQuestion = document.querySelector(`[data-step="${currentStep}"]`);
    if (!currentQuestion) return false;
    const checked = currentQuestion.querySelector('input[type="radio"]:checked');
    return checked !== null;
}

function updateButtonStates() {
    // Mettre à jour les boutons "Suivant" / "Terminer" de la question actuelle
    const currentQuestion = document.querySelector(`[data-step="${currentStep}"]`);
    if (!currentQuestion) return;
    
    const isAnswered = isCurrentQuestionAnswered();
    const nextBtn = currentQuestion.querySelector('.next-btn');
    const submitBtn = currentQuestion.querySelector('.submit-btn');
    
    if (nextBtn) {
        nextBtn.disabled = !isAnswered;
    }
    if (submitBtn) {
        submitBtn.disabled = !isAnswered;
    }
}

function showStep(step) {
    document.querySelectorAll('.question-step').forEach(el => {
        el.classList.add('hidden');
        el.classList.remove('active');
    });
    
    const stepElement = document.querySelector(`[data-step="${step}"]`);
    if (stepElement) {
        stepElement.classList.remove('hidden');
        stepElement.classList.add('active');
    }
    
    currentStep = step;
    updateProgress();
    updateButtonStates();
}

function nextQuestion() {
    if (currentStep < totalSteps && isCurrentQuestionAnswered()) {
        showStep(currentStep + 1);
    }
}

function previousQuestion() {
    if (currentStep > 1) {
        showStep(currentStep - 1);
    }
}

// Initialiser
updateProgress();
updateButtonStates();

// Ajouter des listeners sur tous les radio buttons pour mettre à jour les états
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', updateButtonStates);
});

// Permettre la navigation au clavier (seulement si la question est répondue)
document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight' && isCurrentQuestionAnswered()) {
        nextQuestion();
    } else if (e.key === 'ArrowLeft') {
        previousQuestion();
    }
});
</script>

<style>
.question-step.active {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection