<?php

namespace App;

use App\Sells\Sell;
use App\AssignedProject;
use App\Accounts\Account;
use App\Sells\Leadgeneration;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = ['name', 'email', 'password', 'employee_id', 'department_id', 'signature', 'project_assigned'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'project_assigned' => 'boolean'
    ];

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable')->withDefault();
    }

    public function designation()
    {
        return $this->hasOneThrough(Designation::class, Employee::class, 'id', 'id', 'employee_id', 'designation_id');
    }

    public function head()
    {
        return $this->hasOne(Team::class, 'head_id');
    }

    public function member()
    {
        return $this->hasOne(TeamMember::class, 'member_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function sells()
    {
        return $this->hasMany(Sell::class, 'sell_by');
    }

    public function leads()
    {
        return $this->hasMany(Leadgeneration::class, 'created_by');
    }

    public function assignedProject()
    {
        return $this->hasMany(AssignedProject::class, 'user_id', 'id');
    }

    public function isAdmin()
    {
        return ($this->roles->first()->name == 'admin');
    }

    
}
