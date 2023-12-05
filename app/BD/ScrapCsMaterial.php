<?php

namespace App\BD;

use App\BD\ScrapForm;
use App\Procurement\NestedMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScrapCsMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['scrap_cs_id','scrap_form_id','material_id'];

    public function comparativestatement()
    {
        return $this->belongsTo(ScrapCs::class, 'scrap_cs_id');
    }

    public function nestedMaterial()
    {
        return $this->belongsTo(NestedMaterial::class, 'material_id')->withDefault();
    }

    public function scrapForm(){
        return $this->belongsTo(ScrapForm::class,'scrap_form_id');
    }
}
