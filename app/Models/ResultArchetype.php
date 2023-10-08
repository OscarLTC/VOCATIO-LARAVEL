<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResultArchetype extends Model
{
    use HasFactory;

    protected $table = 'result_archetype';

    protected $fillable = [
        'category_id', 'archetype', 'concept', 'definition', 'characteristics', 'groupArchetype_id'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['groupArchetype_id'];

    public $timestamps = false;

    public function groupArchetype(): BelongsTo
    {
        return $this->belongsTo(GroupArchetype::class, 'groupArchetype_id');
    }

    public function imageArchetype(): HasMany
    {
        return $this->hasMany(ImageArchetype::class, 'resultArchetype_id');
    }
}
