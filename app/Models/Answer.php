<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer';

    protected $fillable = [
        'questionCategory_id', 'questionAlternative_id',  'surveyProgrammingPerson_id'
    ];

    protected $primaryKey = ['questionCategory_id', 'questionAlternative_id', 'surveyProgrammingPerson_id'];

    protected $hidden = ['questionCategory_id', 'questionAlternative_id'];


    public $incrementing = false;

    public function surveyProgrammingPerson(): BelongsTo
    {
        return $this->belongsTo(SurveyProgrammingPerson::class, 'surveyProgrammingPerson_id');
    }

    public function questionAlternative()
    {
        return $this->belongsTo(QuestionAlternative::class, 'questionAlternative_id');
    }

    public function questionCategory()
    {
        return $this->belongsTo(QuestionCategory::class, 'questionCategory_id');
    }

    public $timestamps = false;
}
