<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    protected $table = 'survey';

    protected $fillable = [
        'name'
    ];

    protected $primaryKey = 'id';

    public function question(): HasMany
    {
        return $this->hasMany(Question::class, 'survey_id');
    }

    public function surveyProgramming(): HasMany
    {
        return $this->hasMany(SurveyProgramming::class, 'survey_id');
    }

    public $timestamps = false;
}
