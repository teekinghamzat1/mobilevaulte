<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserCurrency;

class CurrencyController extends Controller
{
    /**
     * Set the primary account currency for the user.
     * This currency will reflect across all user screens, balances, transactions, and preferences.
     */
    public function setCurrency(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'currency_code' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'currency_name' => 'nullable|string|max:100',
            'account_bal' => 'nullable|numeric',
        ]);

        $code = strtoupper(trim($request->currency_code));
        $symbol = trim($request->currency_symbol);
        $name = trim($request->currency_name ?? $code);

        // Update currency on the user account
        $user->currency = $symbol;
        $user->s_currency = $code;
        if ($request->filled('account_bal')) {
            $user->account_bal = $request->account_bal;
        }
        $user->save();

        // Also update or create in user_currencies as default
        UserCurrency::where('user_id', $user->id)->update(['is_default' => false]);
        UserCurrency::updateOrCreate(
            ['user_id' => $user->id, 'currency_code' => $code],
            [
                'currency_symbol' => $symbol,
                'currency_name' => $name,
                'balance' => $user->account_bal,
                'is_default' => true,
            ]
        );

        return redirect()->back()->with('success', "Account currency for {$user->name} has been set to {$code} ({$symbol}). All balances, limits, and transactions will now display in {$code} ({$symbol}).");
    }

    /**
     * Reset the user's account currency to the system default.
     */
    public function resetCurrency(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->currency = null;
        $user->s_currency = null;
        $user->save();

        UserCurrency::where('user_id', $user->id)->update(['is_default' => false]);

        return redirect()->back()->with('success', "Account currency for {$user->name} has been reset to system default.");
    }

    /**
     * Assign / Add a currency to a user.
     */
    public function assign(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'currency_code' => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'currency_name' => 'nullable|string|max:100',
            'balance' => 'nullable|numeric|min:0',
            'is_default' => 'nullable|boolean',
        ]);

        $code = strtoupper(trim($request->currency_code));
        $symbol = trim($request->currency_symbol);
        $name = trim($request->currency_name ?? $code);
        $balance = (float) ($request->balance ?? 0);
        $isDefault = (bool) $request->is_default;

        // Check if currency is already assigned
        $existing = UserCurrency::where('user_id', $user->id)
            ->where('currency_code', $code)
            ->first();

        if ($existing) {
            return redirect()->back()->with('message', "Currency {$code} is already assigned to {$user->name}. You can update its balance directly.");
        }

        // If marked default, unset previous default and update user primary
        if ($isDefault) {
            UserCurrency::where('user_id', $user->id)->update(['is_default' => false]);
            $user->currency = $symbol;
            $user->s_currency = $code;
            $user->save();
        }

        UserCurrency::create([
            'user_id' => $user->id,
            'currency_code' => $code,
            'currency_symbol' => $symbol,
            'currency_name' => $name,
            'balance' => $balance,
            'is_default' => $isDefault,
        ]);

        return redirect()->back()->with('success', "Currency {$code} successfully assigned to {$user->name}!");
    }

    /**
     * Remove an assigned currency from a user.
     */
    public function remove(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'currency_id' => 'required|exists:user_currencies,id',
        ]);

        $currency = UserCurrency::where('id', $request->currency_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $code = $currency->currency_code;
        $wasDefault = $currency->is_default;
        $currency->delete();

        if ($wasDefault) {
            $user->currency = null;
            $user->s_currency = null;
            $user->save();
        }

        return redirect()->back()->with('success', "Currency {$code} successfully removed from {$user->name}!");
    }

    /**
     * Update balance or default status for a user's assigned currency.
     */
    public function updateBalance(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'currency_id' => 'required|exists:user_currencies,id',
            'balance' => 'required|numeric|min:0',
            'is_default' => 'nullable|boolean',
        ]);

        $currency = UserCurrency::where('id', $request->currency_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($request->has('is_default') && $request->is_default) {
            UserCurrency::where('user_id', $user->id)->update(['is_default' => false]);
            $currency->is_default = true;

            $user->currency = $currency->currency_symbol;
            $user->s_currency = $currency->currency_code;
            $user->save();
        }

        $currency->balance = (float) $request->balance;
        $currency->save();

        return redirect()->back()->with('success', "Currency {$currency->currency_code} details updated successfully!");
    }
}
