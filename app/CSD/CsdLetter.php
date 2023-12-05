<?php

namespace App\CSD;

use App\Project;
use App\Sells\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Sells\Sell;
use Spatie\Activitylog\Traits\LogsActivity;

class CsdLetter extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['*'];

    protected $fillable = [
        'letter_title',
        'letter_date',
        'project_id',
        'address_word_one',
        'sell_id',
        'letter_subject',
        'address_word_two',
        'letter_body'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'sell_id')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id')->withDefault();
    }
    public function sell()
    {
        return $this->belongsTo(Sell::class, 'sell_id', 'id');
    }
}
