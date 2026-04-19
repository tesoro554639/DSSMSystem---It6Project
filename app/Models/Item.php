<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $fillable = ['bale_id', 'category_id', 'status_id', 'item_code', 'description', 'price', 'quantity', 'is_sold'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_sold' => 'boolean',
    ];

    public function bale(): BelongsTo
    {
        return $this->belongsTo(Bale::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}