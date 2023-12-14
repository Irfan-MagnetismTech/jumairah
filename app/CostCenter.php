<?php

namespace App;

use App\Accounts\AccountsOpeningBalance;
use App\Procurement\BoqSupremeBudget;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;

    protected $fillable = ['name','project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class)->withDefault();
    }

    public function ledgers()
    {
        return $this->hasMany(LedgerEntry::class,'cost_center_id', 'id');
    }

    public function openingBalances()
    {
        return $this->hasMany(AccountsOpeningBalance::class,'cost_center_id', 'id');
    }

    public function previousLedgers()
    {
        return $this->hasMany(LedgerEntry::class,'cost_center_id', 'id');
    }

    public function boqSupremeBudget()
    {
        return $this->hasMany(BoqSupremeBudget::class, 'project_id', 'project_id');
    }

}
