<?php

namespace App\Procurement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class CsMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['cs_id','material_id'];

    public function comparativestatement()
    {
        return $this->belongsTo(Comparativestatement::class, 'cs_id', 'id');
    }

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }
}
