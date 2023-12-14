<?php

namespace App\Approval;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Department;

class ApprovalLayer extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['name','department_id'];

    /**
     * @return mixed
     */
    public function approvalLeyarDetails()
    {
        return $this->hasMany(ApprovalLayerDetails::class, 'approval_layer_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

}
