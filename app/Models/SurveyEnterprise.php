<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyEnterprise extends Model
{
    use HasFactory;

    protected $table = 'survey_enterprise';

    protected $fillable = [
        'name', 'section', 'survey_id', 'enterprise_id', 'startDate', 'endDate', 'state_id'
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

    public function surveyEnterprisePersons(): HasMany
    {
        return $this->hasMany(SurveyEnterprisePerson::class, 'surveyEnterprise_id');
    }

    public $timestamps = false;
}
