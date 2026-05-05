<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionReceipt extends Model
{
    protected $table = 'transaction_receipts_view';
    public $timestamps = false;
    public $incrementing = false;
}
