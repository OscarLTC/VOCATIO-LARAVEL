<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionCategory extends Model
{
    use HasFactory;

    protected $table = 'question_category';

    protected $fillable = [
        'question_id', 'category_id'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['question_id', 'category_id'];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public $timestamps = false;
}
