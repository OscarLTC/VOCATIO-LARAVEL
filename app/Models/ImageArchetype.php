<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageArchetype extends Model
{
    use HasFactory;

    protected $table = 'image_archetype';

    protected $fillable = [
        'image', 'resultArchetype_id'
    ];

    protected $hidden = ['resultArchetype_id'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
