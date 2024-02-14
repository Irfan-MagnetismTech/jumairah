<?php

namespace Modules\HR\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function loan_application()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
