<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinesLine extends Model
{
    use HasFactory;

    protected $table = 'bussines_line';

    protected $fillable = ['description'];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
