<?php

namespace App\BD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BdFeasiRncCalSale extends Model
{
    use HasFactory;
    protected $fillable = ['row_1st','row_2nd','row_3rd','row_4th','row_5th','row_6th','row_7th','row_8th','row_9th','row_10th'];
}
