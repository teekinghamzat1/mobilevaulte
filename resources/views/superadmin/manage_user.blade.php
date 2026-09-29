@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('superadmin.sidebar')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="title1 d-inline text-primary"><i class="fas fa-user-cog mr-2"></i>Configure Account: {{ $user->name }}</h1>
                        <p class="text-muted mb-0">
                            Username: <strong>{{ $user->username }}</strong> | Email: <strong>{{ $user->email }}</strong> | Account #: <strong>{{ $user->usernumber ?? 'N/A' }}</strong>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('superadmin.users') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Users List
                        </a>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <div class="row">
                    <!-- SECTION 1: SECURITY QUESTION -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-primary mb-0">
                                    <i class="fas fa-shield-alt mr-2"></i>Security Question Configuration
                                </h4>
                                @if($user->security_question_enabled)
                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Active</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">Disabled</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3">
                                    When enabled, this user will be challenged with this security question immediately following successful PIN verification before dashboard access is permitted.
                                </p>

                                <form method="POST" action="{{ route('superadmin.users.security.update', $user->id) }}">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Security Question Status</label>
                                        <div class="d-flex align-items-center">
                                            <div class="custom-control custom-radio mr-4">
                                                <input type="radio" id="sec_disable" name="security_question_enabled" value="0" class="custom-control-input" {{ !$user->security_question_enabled ? 'checked' : '' }} onchange="toggleSecFields(false)">
                                                <label class="custom-control-label font-weight-normal" for="sec_disable">Disabled (Standard PIN only)</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sec_enable" name="security_question_enabled" value="1" class="custom-control-input" {{ $user->security_question_enabled ? 'checked' : '' }} onchange="toggleSecFields(true)">
                                                <label class="custom-control-label font-weight-normal text-primary font-weight-bold" for="sec_enable">Enabled (Require Security Question)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="securityFields" style="{{ !$user->security_question_enabled ? 'opacity: 0.7;' : '' }}">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Quick Select Common Question</label>
                                            <select class="form-control" onchange="if(this.value) document.getElementById('security_question_input').value = this.value;">
                                                <option value="">-- Choose a standard question or type custom below --</option>
                                                <option value="What is the name of your first elementary school?">What is the name of your first elementary school?</option>
                                                <option value="What was the model of your first car?">What was the model of your first car?</option>
                                                <option value="In what city was your father or mother born?">In what city was your father or mother born?</option>
                                                <option value="What was the name of your favorite childhood pet?">What was the name of your favorite childhood pet?</option>
                                                <option value="What is your maternal grandmother's maiden name?">What is your maternal grandmother's maiden name?</option>
                                                <option value="What street did you grow up on as a child?">What street did you grow up on as a child?</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold">Security Question Text <span class="text-danger">*</span></label>
                                            <input type="text" id="security_question_input" name="security_question" class="form-control" placeholder="e.g. What was your childhood nickname?" value="{{ old('security_question', $user->security_question) }}">
                                            <small class="form-text text-muted">This question will be shown to the user on the login challenge screen.</small>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="font-weight-bold">Security Question Answer <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="security_answer_input" name="security_answer" class="form-control" placeholder="Answer required from user" value="{{ old('security_answer', $user->security_answer) }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="toggleAnswerVisibility()" title="Toggle Answer Visibility">
                                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Verification is case-insensitive. User input must match this configured answer.</small>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save mr-1"></i> Save Security Question Settings
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: ACCOUNT CURRENCY MANAGEMENT -->
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-success mb-0">
                                    <i class="fas fa-coins mr-2"></i>Account Currency Settings
                                </h4>
                                @if(!empty($user->s_currency))
                                    <span class="badge badge-success px-2 py-1">
                                        <i class="fas fa-check mr-1"></i> {{ $user->s_currency }} ({{ $user->currency }})
                                    </span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">
                                        Default ({{ $settings->s_currency ?? 'USD' }})
                                    </span>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info py-2 px-3 mb-3 small">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    When you select a currency here, <strong>{{ $user->name }}'s</strong> account will display this chosen currency across all screens, available balances, transaction limits, pending transactions, and statements. The UI layout remains completely intact.
                                </div>

                                <!-- Primary Account Currency Form -->
                                <form method="POST" action="{{ route('superadmin.users.currency.set', $user->id) }}">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold">Select Currency</label>
                                        <select id="primary_currency_preset" class="form-control" onchange="populatePrimaryCurrency(this)">
                                            <option value="">-- Choose from standard currencies --</option>
                                            @foreach($availableCurrencies as $code => $data)
                                                <option value="{{ $code }}" data-symbol="{{ $data['symbol'] }}" data-name="{{ $data['name'] }}" {{ ($user->s_currency == $code) ? 'selected' : '' }}>
                                                    {{ $code }} - {{ $data['name'] }} ({{ $data['symbol'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold">Currency Code <span class="text-danger">*</span></label>
                                            <input type="text" name="currency_code" id="primary_currency_code" class="form-control" placeholder="e.g. USD, EUR, GBP" value="{{ old('currency_code', $user->s_currency ?? ($settings->s_currency ?? 'USD')) }}" required>
                                            <small class="text-muted">Used for codes (e.g. USD, EUR, NGN)</small>
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold">Currency Symbol <span class="text-danger">*</span></label>
                                            <input type="text" name="currency_symbol" id="primary_currency_symbol" class="form-control" placeholder="e.g. $, €, £, ₦" value="{{ old('currency_symbol', $user->currency ?? ($settings->currency ?? '$')) }}" required>
                                            <small class="text-muted">Used as symbol prefix (e.g. $, €, £)</small>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold">Currency Name</label>
                                            <input type="text" name="currency_name" id="primary_currency_name" class="form-control" placeholder="e.g. US Dollar" value="{{ old('currency_name') }}">
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold">Account Balance</label>
                                            <input type="number" step="0.01" name="account_bal" class="form-control" placeholder="0.00" value="{{ old('account_bal', $user->account_bal) }}">
                                            <small class="text-muted">Current balance in this currency</small>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <button type="submit" class="btn btn-success flex-grow-1 mr-2">
                                            <i class="fas fa-check-circle mr-1"></i> Save & Apply Currency
                                        </button>
                                    </div>
                                </form>

                                @if(!empty($user->s_currency) || !empty($user->currency))
                                    <form method="POST" action="{{ route('superadmin.users.currency.reset', $user->id) }}" class="mt-2" onsubmit="return confirm('Reset currency for {{ $user->name }} back to system default ({{ $settings->s_currency ?? 'USD' }})?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary btn-sm btn-block">
                                            <i class="fas fa-undo mr-1"></i> Reset to System Default ({{ $settings->s_currency ?? 'USD' }})
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleSecFields(enabled) {
            const fields = document.getElementById('securityFields');
            if (fields) {
                fields.style.opacity = enabled ? '1' : '0.6';
            }
        }

        function toggleAnswerVisibility() {
            const input = document.getElementById('security_answer_input');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        function populatePrimaryCurrency(select) {
            const selected = select.options[select.selectedIndex];
            if (selected && selected.value) {
                document.getElementById('primary_currency_code').value = selected.value;
                document.getElementById('primary_currency_symbol').value = selected.getAttribute('data-symbol') || '';
                document.getElementById('primary_currency_name').value = selected.getAttribute('data-name') || '';
            }
        }

        function populateCurrencyData(select) {
            const selected = select.options[select.selectedIndex];
            if (selected && selected.value) {
                document.getElementById('currency_code').value = selected.value;
                document.getElementById('currency_symbol').value = selected.getAttribute('data-symbol') || '';
                document.getElementById('currency_name').value = selected.getAttribute('data-name') || '';
            }
        }
    </script>
@endsection
