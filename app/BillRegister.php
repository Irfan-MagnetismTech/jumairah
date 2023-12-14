<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Procurement\Supplier;
use App\Employee;
use App\Department;

class BillRegister extends Model
{
    use HasFactory;

    protected $table = 'bill_registers';

    protected $fillable = ['serial_no', 'bill_no', 'supplier_id', 'amount','status','department_id', 'deliver_status', 'accepted_date','delivery_date','user_id', 'delivery_date', 'approval_status'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

   public function department()
          {
              return $this->belongsTo(Department::class);
          }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
