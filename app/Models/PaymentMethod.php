<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'method_name',
        'description'
    ];
        
    /**
     * Get the transactions for the payment method.
     */
    public function transactions(): HasMany 
    {
        return $this->hasMany(Transaction::class, 'method_id');
    }
}