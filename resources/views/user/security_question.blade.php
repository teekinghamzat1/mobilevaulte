@extends('layouts.auth')
@section('title', 'Security Question Verification')
@section('content')

<div x-data="{
    answer: '',
    isProcessing: false,
    errorMessage: '',
    successMessage: '',

    async submitAnswer() {
        if (!this.answer.trim()) {
            this.errorMessage = 'Please enter your answer';
            setTimeout(() => this.errorMessage = '', 3000);
            return;
        }

        this.isProcessing = true;
        this.errorMessage = '';

        try {
            const response = await fetch('{{ route('security.verify') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ answer: this.answer })
            });

            const result = await response.json();

            if (result.success) {
                this.successMessage = result.message || 'Security question verified!';

                if (document.getElementById('success-checkmark')) {
                    document.getElementById('success-checkmark').classList.remove('hidden');
                }

                setTimeout(() => {
                    window.location.href = result.redirect || '{{ route('dashboard') }}';
                }, 1000);
            } else {
                this.errorMessage = result.message || 'Incorrect answer. Please try again.';

                const answerInput = document.getElementById('security-answer-input');
                if (answerInput) {
                    answerInput.classList.add('border-red-500', 'animate-shake');
                    setTimeout(() => answerInput.classList.remove('border-red-500', 'animate-shake'), 500);
                }

                setTimeout(() => this.errorMessage = '', 4000);
            }
        } catch (error) {
            this.errorMessage = 'An error occurred. Please try again.';
            setTimeout(() => this.errorMessage = '', 3000);
        } finally {
            this.isProcessing = false;
        }
    }
}" class="flex items-center justify-center min-h-screen w-full bg-gradient-to-br from-gray-50 to-gray-100 p-4">

    <!-- Card Container -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:shadow-3xl">

        <!-- Header with Gradient -->
        <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 opacity-95"></div>

            <div class="relative py-10 px-6 flex flex-col items-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i data-lucide="shield-question" class="h-10 w-10 text-white"></i>
                </div>

                <h1 class="text-2xl font-bold text-white text-center mb-1">Security Check</h1>
                <p class="text-white/90 text-center max-w-xs text-sm">
                    Step 2 of 2: Answer your assigned security question
                </p>
            </div>
        </div>

        <!-- User Info Area -->
        <div class="flex flex-col items-center pt-6 pb-2">
            <div class="relative">
                <div class="w-20 h-20 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    <img
                        src="{{ asset('storage/app/public/photos/'.Auth::user()->profile_photo_path)}}"
                        alt="{{ Auth::user()->name }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF';"
                        class="w-full h-full object-cover">
                </div>

                <div class="absolute -right-1 -bottom-1 bg-green-100 text-green-700 p-1.5 rounded-full border-2 border-white shadow-md">
                    <i data-lucide="check" class="h-4 w-4"></i>
                </div>
            </div>

            <h2 class="text-lg font-bold text-gray-800 mt-2">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
        </div>

        <!-- Security Question & Answer Form -->
        <div class="p-6 pt-2">
            <!-- Question Box -->
            <div class="bg-primary-50/70 border border-primary-100 rounded-2xl p-4 mb-4 text-center">
                <p class="text-xs font-semibold text-primary-700 uppercase tracking-wider mb-1">Security Question</p>
                <p class="text-gray-800 font-medium text-base">
                    "{{ Auth::user()->security_question }}"
                </p>
            </div>

            <!-- Error and Success Messages -->
            <div x-show="errorMessage" x-transition class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl text-center">
                <i data-lucide="alert-circle" class="inline h-4 w-4 mr-1"></i>
                <span x-text="errorMessage"></span>
            </div>

            <div x-show="successMessage" x-transition class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl text-center flex items-center justify-center">
                <i data-lucide="check-circle" class="h-4 w-4 mr-1 text-green-600" id="success-checkmark"></i>
                <span x-text="successMessage"></span>
            </div>

            <form @submit.prevent="submitAnswer()">
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Your Secret Answer</label>
                    <div class="relative">
                        <input
                            type="text"
                            id="security-answer-input"
                            x-model="answer"
                            placeholder="Enter your security answer..."
                            autocomplete="off"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all text-gray-800 placeholder-gray-400"
                            :disabled="isProcessing">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Answer is case-insensitive.</p>
                </div>

                <button
                    type="submit"
                    :disabled="isProcessing"
                    class="w-full py-3.5 px-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center space-x-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <span x-show="!isProcessing">Confirm & Access Account</span>
                    <span x-show="isProcessing" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verifying...
                    </span>
                    <i x-show="!isProcessing" data-lucide="arrow-right" class="h-4 w-4"></i>
                </button>
            </form>

            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-red-600 transition-colors">
                        <i data-lucide="log-out" class="inline h-3 w-3 mr-1"></i> Log out & cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

@endsection
