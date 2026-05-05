<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRevenue extends Model
{
    protected $table = 'daily_revenue_report';
    public $timestamps = false;
    public $incrementing = false; 
}