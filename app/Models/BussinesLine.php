<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BussinesLine extends Model
{
    use HasFactory;

    protected $table = 'bussines_line';

    protected $fillable = ['name'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
