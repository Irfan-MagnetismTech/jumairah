<?php

namespace App;

use App\Casts\CommaToFloat;
use App\Sells\CollectionYearlyBudget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionYearlyBudgetDetails extends Model
{
    use HasFactory;

    protected $fillable = ['month','collection_amount'];

    public function collectionYearlyBudget()
    {
        return $this->belongsTo(CollectionYearlyBudget::class,'yearly_budget_id')->withDefault();
    }

    protected $casts = [
        'collection_amount'     => CommaToFloat::class,
    ];
}
