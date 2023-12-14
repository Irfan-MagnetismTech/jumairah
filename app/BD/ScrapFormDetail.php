<?php

namespace App\BD;

use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapFormDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'material_id',
        'quantity',
        'remarks'
    ];

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id');
    }

    public function scrapForm()
    {
        return $this->belongsTo(ScrapForm::class, 'scrap_form_id', 'id');
    }
}
