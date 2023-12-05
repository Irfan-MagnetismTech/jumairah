<?php

namespace App\Boq\Departments\Eme;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Procurement\NestedMaterial;
use App\Boq\Configurations\BoqWork;

class BoqEmeLaborRateDetail extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'labor_rate', 'qty', 'boq_work_id'];

    public function NestedMaterial(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id')->withDefault();
    }

    public function boqWork(): BelongsTo
    {
        return $this->belongsTo(BoqWork::class, 'boq_work_id', 'id')->withDefault();
    }
}
