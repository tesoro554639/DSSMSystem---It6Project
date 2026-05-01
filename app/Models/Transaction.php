<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Transaction extends Model
{
    protected $fillable = ['user_id', 'transaction_number', 'subtotal', 'total_amount', 'method_id', 'notes'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'transaction_items')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    public static function generateTransactionNumber(): string
    {
        $prefix = 'TRX-' . date('Ymd');
        $lastTransaction = self::where('transaction_number', 'like', $prefix . '%')
            ->orderBy('transaction_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->transaction_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}