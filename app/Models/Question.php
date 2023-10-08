<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'question';

    protected $fillable = [
        'survey_id', 'description'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['survey_id'];

    public function questionAlternative(): HasMany
    {
        return $this->hasMany(QuestionAlternative::class, 'question_id');
    }

    public function questionCategory(): HasMany
    {
        return $this->hasMany(QuestionCategory::class, 'question_id');
    }

    public $timestamps = false;
}
