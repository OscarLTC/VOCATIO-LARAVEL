<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    use HasFactory;

    protected $table = 'document_type';

    protected $fillable = ['description'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
