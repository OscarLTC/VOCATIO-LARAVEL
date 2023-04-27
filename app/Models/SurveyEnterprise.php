<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyEnterprise extends Model
{
    use HasFactory;

    protected $table = 'survey_enterprise';

    protected $fillable = [
        'name', 'survey_id', 'enterprise_id', 'startDate', 'endDate', 'state_id'
    ];

    protected $hidden = ['survey_id', 'enterprise_id', 'state_id'];

    protected $primaryKey = 'id';


    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public $timestamps = false;
}
