<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addToWallet($amount)
    {
        (double) $this->balance += (double) $amount;
    }

    public function reduceFromWallet($amount)
    {
        (double) $this->balance -= (double) $amount;
    }

    public function getFormattedBalanceAttribute()
    {
        return Money::NGN($this->balance, true);
    }
}
