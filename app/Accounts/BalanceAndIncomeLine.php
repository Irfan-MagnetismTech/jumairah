<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class BalanceAndIncomeLine extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = [];
    protected $tables = "balance_and_income_lines";

    public function parent(){
        return $this->belongsTo(BalanceAndIncomeLine::class, 'parent_id', 'id')->withDefault();
    }

    public function accounts()
    {
        return $this->hasMany(Account::class,'balance_and_income_line_id','id');
    }

}
