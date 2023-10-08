<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyProgramming extends Model
{
    use HasFactory;

    protected $table = 'survey_programming';

    protected $fillable = [
        'name', 'section', 'survey_id', 'enterprise_id', 'state_id', 'startDate', 'endDate'
    ];

    protected $primaryKey = 'id';


    protected $hidden = ['survey_id'];

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

    public function surveyProgrammingPerson(): HasMany
    {
        return $this->hasMany(SurveyProgrammingPerson::class, 'surveyProgramming_id');
    }

    public $timestamps = false;
}
