<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterCompany extends Model
{
    use HasFactory;
    protected $fillable=['name','address','office_phone','contact_person','contact_person_cell'];

    public function loans()
    {
        return $this->morphMany(Loan::class, 'loanable');
    }
}
