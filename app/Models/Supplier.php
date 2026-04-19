<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = ['name', 'contact_person', 'phone', 'address'];

    public function bales(): HasMany
    {
        return $this->hasMany(Bale::class);
    }
}