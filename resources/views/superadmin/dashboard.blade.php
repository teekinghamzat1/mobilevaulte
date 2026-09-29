@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('superadmin.sidebar')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="title1 d-inline text-primary"><i class="fas fa-crown text-warning mr-2"></i>Super Admin Portal</h1>
                        <p class="text-muted mb-0">Exclusive management area for Multi-Currency and Security Questions</p>
                    </div>
                    <div>
                        <a href="{{ route('superadmin.users') }}" class="btn btn-primary btn-round">
                            <i class="fas fa-users-cog mr-1"></i> Manage Users
                        </a>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Summary Cards Row -->
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round shadow-sm border-left-primary">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Total Accounts</p>
                                            <h4 class="card-title">{{ number_format($totalUsers) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round shadow-sm border-left-success">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-success bubble-shadow-small">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Security Questions Active</p>
                                            <h4 class="card-title">{{ number_format($usersWithSecQuestions) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="card card-stats card-round shadow-sm border-left-info">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div class="icon-big text-center icon-info bubble-shadow-small">
                                            <i class="fas fa-coins"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ml-3 ml-sm-0">
                                        <div class="numbers">
                                            <p class="card-category">Assigned User Currencies</p>
                                            <h4 class="card-title">{{ number_format($totalAssignedCurrencies) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Quick Overview -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                <h4 class="card-title text-primary mb-0"><i class="fas fa-shield-alt mr-2"></i>Security Questions Policy</h4>
                                <span class="badge badge-primary">Super Admin Only</span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    Enforce an additional challenge for select user accounts. When enabled, users must answer their custom security question following successful PIN entry:
                                </p>
                                <div class="p-3 bg-light rounded border mb-3">
                                    <span class="badge badge-dark">Standard:</span> Username & Password &rarr; PIN &rarr; Account<br>
                                    <span class="badge badge-success mt-2">Enhanced:</span> Username & Password &rarr; PIN &rarr; <strong class="text-primary">Security Question</strong> &rarr; Account
                                </div>
                                <a href="{{ route('superadmin.users') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-sliders-h mr-1"></i> Configure User Security
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                                <h4 class="card-title text-success mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Multi-Currency Management</h4>
                                <span class="badge badge-success">Super Admin Only</span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">
                                    Customize which currencies are active on individual user accounts. Add, remove, and manage balances across global fiat currencies (USD, EUR, GBP, NGN, etc.).
                                </p>
                                <div class="p-3 bg-light rounded border mb-3">
                                    <i class="fas fa-check-circle text-success mr-1"></i> Per-account currency assignment<br>
                                    <i class="fas fa-check-circle text-success mr-1"></i> Dedicated balance tracking per currency<br>
                                    <i class="fas fa-check-circle text-success mr-1"></i> Displayed directly on customer dashboard
                                </div>
                                <a href="{{ route('superadmin.users') }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-coins mr-1"></i> Manage User Currencies
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users List -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Recent User Accounts</h4>
                                <a href="{{ route('superadmin.users') }}" class="btn btn-sm btn-link">View All Users &rarr;</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Account No.</th>
                                                <th>Security Question</th>
                                                <th>Assigned Currencies</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentUsers as $user)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $user->email }}</small>
                                                    </td>
                                                    <td>{{ $user->usernumber ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($user->security_question_enabled)
                                                            <span class="badge badge-success"><i class="fas fa-lock mr-1"></i> Enabled</span>
                                                        @else
                                                            <span class="badge badge-secondary">Disabled</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($user->s_currency))
                                                            <span class="badge badge-success font-weight-bold">{{ $user->s_currency }} ({{ $user->currency }})</span>
                                                        @elseif($user->currencies && $user->currencies->count() > 0)
                                                            <span class="badge badge-info">{{ $user->currencies->first()->currency_code }} ({{ $user->currencies->first()->currency_symbol }})</span>
                                                        @else
                                                            <span class="badge badge-light text-muted border">Default ({{ $settings->s_currency ?? 'USD' }})</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="{{ route('superadmin.users.manage', $user->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-cog mr-1"></i> Manage
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
