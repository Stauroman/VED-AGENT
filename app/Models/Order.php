<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public const int MIN_WEIGHT = 30;
    public const int MAX_WEIGHT = 100000;

    protected $fillable = ['company_id', 'weight', 'distance', 'amount'];
}
