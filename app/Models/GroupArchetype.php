<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupArchetype extends Model
{
    use HasFactory;

    protected $table = 'group_archetype';

    protected $fillable = [
        'hero', 'color'
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
