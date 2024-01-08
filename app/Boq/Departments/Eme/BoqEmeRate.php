<?php

namespace App\Boq\Departments\Eme;

use App\Boq\Configurations\BoqWork;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Model;
use App\Boq\Departments\Eme\EmeLaborHead;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoqEmeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id_second',
        'material_id',
        'labour_rate',
        'boq_work_name',
        'type'
    ];

    public function NestedMaterial(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id', 'id')->withDefault();
    }

    public function NestedMaterialSecondLayer(): BelongsTo
    {
        return $this->belongsTo(NestedMaterial::class, 'parent_id_second', 'id')->withDefault();
    }

    public function boqWork(): BelongsTo
    {
        return $this->belongsTo(BoqWork::class)->withDefault();
    }

    public function emeWork(): BelongsTo
    {
        return $this->belongsTo(EmeLaborHead::class, 'parent_id_second', 'id')->withDefault();
    }
}
