<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCurrency extends Model
{
    use HasFactory;

    protected $table = 'user_currencies';

    protected $fillable = [
        'user_id',
        'currency_code',
        'currency_symbol',
        'currency_name',
        'balance',
        'is_default',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns this currency.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
