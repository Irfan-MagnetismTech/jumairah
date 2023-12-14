<?php

namespace App\Approval;

use App\User;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = ['layer_key', 'user_id', 'status'];

    public function approvable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function approvalLayerDetails()
    {
        return $this->hasOne(ApprovalLayerDetails::class, 'layer_key', 'layer_key');
    }

    public function getStatusAttribute($input)
    {
        if ($input == '0') {
            $status =  'Rejected';
        } elseif ($input == '1') {
            $status =  'Approved';
        } else {
            $status =  'Pending';
        }
        return $status;
    }
}
