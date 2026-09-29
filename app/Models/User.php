<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use App\Models\Settings;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */

    public function sendEmailVerificationNotification()
    {
        $settings = Settings::where('id', 1)->first();

        if ($settings->enable_verification == 'true') {
            $this->notify(new VerifyEmail);
        }

    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function dp(){
    	return $this->hasMany(Deposit::class, 'user');
    }

    public function wd(){
    	return $this->hasMany(Withdrawal::class, 'user');
    }

    public function tuser(){
    	return $this->belongsTo(Admin::class, 'assign_to');
    }

    public function dplan(){
    	return $this->belongsTo(Plans::class, 'plan');
    }

    public function plans(){
        return $this->hasMany(User_plans::class,'user', 'id');
    }

    public static function search($search): \Illuminate\Database\Eloquent\Builder
    {
        return empty($search) ? static::query()
        : static::query()->where(function($query) use ($search) {
            $query->where('id', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('username', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%');
        });
    }

    /**
     * Get the cards for the user.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the notifications associated with the user.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the statuses for the user.
     */
    public function accountStatuses()
    {
        return $this->hasMany(AccountStatus::class, 'user_id')->orderBy('created_at', 'desc');
    }

    /**
     * Check if the user is currently suspended based on the latest status.
     *
     * @return bool
     */
    public function isSuspended()
    {
        $latestStatus = $this->accountStatuses()->first();
        return $latestStatus && $latestStatus->stop_usage;
    }

    /**
     * Get the number of unread notifications for the user.
     *
     * @return int
     */
    public function unreadNotificationsCount()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * Get assigned currencies for this user.
     */
    public function currencies()
    {
        return $this->hasMany(UserCurrency::class);
    }

    /**
     * Get active account currency symbol (fallback to system setting).
     */
    public function getActiveCurrencySymbolAttribute()
    {
        if (!empty($this->currency)) {
            return $this->currency;
        }
        $default = $this->currencies()->where('is_default', true)->first() ?? $this->currencies()->first();
        if ($default) {
            return $default->currency_symbol;
        }
        return optional(Settings::where('id', 1)->first())->currency ?? '$';
    }

    /**
     * Get active account currency code (fallback to system setting).
     */
    public function getActiveCurrencyCodeAttribute()
    {
        if (!empty($this->s_currency)) {
            return $this->s_currency;
        }
        $default = $this->currencies()->where('is_default', true)->first() ?? $this->currencies()->first();
        if ($default) {
            return $default->currency_code;
        }
        return optional(Settings::where('id', 1)->first())->s_currency ?? 'USD';
    }
}

