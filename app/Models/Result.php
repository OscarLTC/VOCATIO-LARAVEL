<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $table = 'result';

    protected $fillable = [
        'learningStyle', 'dominantCategory', 'mainFeatures', 'keywords', 'recommnendations'
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
