<?php

namespace App\Approval;

use App\Department;
use App\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalLayerDetails extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['department_id','designation_id', 'name','layer_key', 'order_by'];

    /**
     * @return mixed
     */
    public function approvalLayer()
    {
        return $this->belongsTo(ApprovalLayer::class)->withDefault();
    }

    /**
     * @return mixed
     */
    public function approvals()
    {
        return $this->hasOne(Approval::class, 'layer_key', 'layer_key');
    }


    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
