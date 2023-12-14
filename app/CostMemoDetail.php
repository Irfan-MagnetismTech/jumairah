<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostMemoDetail extends Model
{
    use HasFactory;
    protected $fillable = ['cost_memo_id', 'particulers', 'amount'];
}
