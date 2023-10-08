<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionAlternative extends Model
{
    use HasFactory;

    protected $table = 'question_alternative';

    protected $fillable = [
        'question_id', 'alternative_id', 'value'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['question_id', 'alternative_id'];

    protected $casts = [
        'value' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function alternative(): BelongsTo
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }


    public $timestamps = false;
}
