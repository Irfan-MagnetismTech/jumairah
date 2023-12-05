<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellCollectionHead extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function salesCollections()
    {
        return $this->hasMany(SalesCollection::class, 'sell_id');
    }
}
