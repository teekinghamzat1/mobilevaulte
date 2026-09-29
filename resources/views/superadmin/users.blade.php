@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('superadmin.sidebar')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="title1 d-inline text-primary"><i class="fas fa-users-cog mr-2"></i>User Security & Currency Management</h1>
                        <p class="text-muted mb-0">Select an account to configure optional security questions and assigned currencies</p>
                    </div>
                    <div>
                        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Overview
                        </a>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Filter & Search Bar -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('superadmin.users') }}" class="row align-items-end">
                            <div class="col-md-5 mb-2 mb-md-0">
                                <label class="small font-weight-bold text-muted">Search User</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, username or account #..." value="{{ $search }}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label class="small font-weight-bold text-muted">Security Question Status</label>
                                <select name="sec_status" class="form-control">
                                    <option value="">All Accounts</option>
                                    <option value="enabled" {{ $sec_status === 'enabled' ? 'selected' : '' }}>Security Question Enabled</option>
                                    <option value="disabled" {{ $sec_status === 'disabled' ? 'selected' : '' }}>Security Question Disabled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter mr-1"></i> Apply Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Registered Accounts ({{ $users->total() }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name & Username</th>
                                        <th>Email</th>
                                        <th>Account Number</th>
                                        <th>Security Question</th>
                                        <th>Account Currency</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                                <br>
                                                <small class="text-muted"><i class="fas fa-user mr-1"></i>{{ $user->username }}</small>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge badge-light border">{{ $user->usernumber ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if($user->security_question_enabled)
                                                    <span class="badge badge-success px-2 py-1"><i class="fas fa-shield-alt mr-1"></i> Enabled</span>
                                                    <br>
                                                    <small class="text-truncate d-inline-block text-muted" style="max-width: 180px;" title="{{ $user->security_question }}">
                                                        {{ $user->security_question }}
                                                    </small>
                                                @else
                                                    <span class="badge badge-secondary px-2 py-1">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($user->s_currency))
                                                    <span class="badge badge-success px-2 py-1 font-weight-bold">
                                                        <i class="fas fa-coins mr-1"></i> {{ $user->s_currency }} ({{ $user->currency }})
                                                    </span>
                                                @elseif($user->currencies && $user->currencies->count() > 0)
                                                    <span class="badge badge-info px-2 py-1 font-weight-bold">
                                                        {{ $user->currencies->first()->currency_code }} ({{ $user->currencies->first()->currency_symbol }})
                                                    </span>
                                                @else
                                                    <span class="badge badge-light text-muted border">Default ({{ $settings->s_currency ?? 'USD' }})</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('superadmin.users.manage', $user->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-sliders-h mr-1"></i> Configure
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-5">
                                                <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                                                No user accounts matched the filter criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
