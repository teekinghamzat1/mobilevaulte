<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCurrency;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    /**
     * Show Super Admin dashboard.
     */
    public function dashboard()
    {
        $settings = Settings::where('id', 1)->first();
        $totalUsers = User::count();
        $usersWithSecQuestions = User::where('security_question_enabled', true)->count();
        $totalAssignedCurrencies = UserCurrency::count();
        $recentUsers = User::orderByDesc('id')->take(8)->get();

        return view('admin.security-currencies.dashboard', [
            'title' => 'Super Admin Dashboard',
            'settings' => $settings,
            'totalUsers' => $totalUsers,
            'usersWithSecQuestions' => $usersWithSecQuestions,
            'totalAssignedCurrencies' => $totalAssignedCurrencies,
            'recentUsers' => $recentUsers,
        ]);
    }

    /**
     * List all users with search and filter.
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('usernumber', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sec_status')) {
            if ($request->sec_status === 'enabled') {
                $query->where('security_question_enabled', true);
            } elseif ($request->sec_status === 'disabled') {
                $query->where('security_question_enabled', false);
            }
        }

        $users = $query->with('currencies')->orderByDesc('id')->paginate(15);
        $settings = Settings::where('id', 1)->first();

        return view('admin.security-currencies.users', [
            'title' => 'Manage User Accounts',
            'users' => $users,
            'settings' => $settings,
            'search' => $request->search,
            'sec_status' => $request->sec_status,
        ]);
    }

    /**
     * View and manage a specific user's Super Admin settings:
     * Security Questions & Currencies.
     */
    public function manageUser($id)
    {
        $user = User::with('currencies')->findOrFail($id);
        $settings = Settings::where('id', 1)->first();

        // Catalog of standard currencies that can be assigned
        $availableCurrencies = [
            'USD' => ['name' => 'US Dollar', 'symbol' => '$'],
            'EUR' => ['name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['name' => 'British Pound', 'symbol' => '£'],
            'NGN' => ['name' => 'Nigerian Naira', 'symbol' => '₦'],
            'CAD' => ['name' => 'Canadian Dollar', 'symbol' => 'CA$'],
            'AUD' => ['name' => 'Australian Dollar', 'symbol' => 'A$'],
            'JPY' => ['name' => 'Japanese Yen', 'symbol' => '¥'],
            'CHF' => ['name' => 'Swiss Franc', 'symbol' => 'CHF'],
            'CNY' => ['name' => 'Chinese Yuan', 'symbol' => '¥'],
            'INR' => ['name' => 'Indian Rupee', 'symbol' => '₹'],
            'ZAR' => ['name' => 'South African Rand', 'symbol' => 'R'],
            'AED' => ['name' => 'UAE Dirham', 'symbol' => 'AED'],
            'GHS' => ['name' => 'Ghanaian Cedi', 'symbol' => 'GH₵'],
            'KES' => ['name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
        ];

        return view('admin.security-currencies.manage_user', [
            'title' => "Super Admin - Manage {$user->name}",
            'user' => $user,
            'settings' => $settings,
            'availableCurrencies' => $availableCurrencies,
        ]);
    }
}
