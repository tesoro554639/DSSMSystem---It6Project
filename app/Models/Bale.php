<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bale extends Model
{
    protected $fillable = ['bale_number', 'supplier_id', 'purchase_price', 'total_items', 'purchase_date', 'notes'];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}