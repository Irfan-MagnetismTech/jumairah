<?php

namespace App\Procurement;

use App\Accounts\Account;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['type', 'country', 'name','address','contact','email','section_id', 'contact_person_name', 'accountable_type'];

    public function account()
    {
        return $this->morphOne(Account::class,'accountable')->withDefault();
    }

    public function cssupplier()
    {
        return $this->hasMany(CsSupplier::class);
    }
}
