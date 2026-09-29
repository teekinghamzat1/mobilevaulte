<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use Illuminate\Support\Facades\View;

class AccountCurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Overrides system settings currency with the authenticated user's chosen currency
     * across all views, messages, preferences, and account screens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            $currencySymbol = null;
            $currencyCode = null;

            if (!empty($user->currency) || !empty($user->s_currency)) {
                $currencySymbol = $user->currency;
                $currencyCode = $user->s_currency;
            } elseif (method_exists($user, 'currencies')) {
                $defaultCurrency = $user->currencies()->where('is_default', true)->first()
                    ?? $user->currencies()->first();
                if ($defaultCurrency) {
                    $currencySymbol = $defaultCurrency->currency_symbol;
                    $currencyCode = $defaultCurrency->currency_code;
                }
            }

            if ($currencySymbol || $currencyCode) {
                $settings = Settings::where('id', '1')->first();
                if ($settings) {
                    if ($currencySymbol) {
                        $settings->currency = $currencySymbol;
                    }
                    if ($currencyCode) {
                        $settings->s_currency = $currencyCode;
                    }
                    View::share('settings', $settings);
                }
            }
        }

        return $next($request);
    }
}
