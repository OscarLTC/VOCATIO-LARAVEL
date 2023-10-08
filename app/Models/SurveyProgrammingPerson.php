<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SurveyProgrammingPerson extends Model
{
    use HasFactory;

    protected $table = 'survey_programming_person';

    protected $fillable = [
        'surveyProgramming_id', 'person_id', 'state_id', 'endDate', 'pdfBlob'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['surveyProgramming_id', 'person_id'];


    public function surveyProgramming(): BelongsTo
    {
        return $this->belongsTo(SurveyProgramming::class, 'surveyProgramming_id');
    }
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'surveyProgrammingPerson_id');
    }

    public $timestamps = false;
}
