<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyEnterprisePerson extends Model
{
    use HasFactory;


    protected $table = 'survey_enterprise_person';

    protected $fillable = [
        'surveyEnterprise_id', 'person_id', 'result_id', 'state_id', 'end_date'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['surveyEnterprise_id', 'person_id', 'result_id', 'state_id'];

    public function surveyEnterprise(): BelongsTo
    {
        return $this->belongsTo(SurveyEnterprise::class, 'surveyEnterprise_id');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'surveyEnterprisePerson_id');
    }

    public $timestamps = false;
}
