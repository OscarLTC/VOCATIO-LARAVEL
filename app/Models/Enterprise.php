<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enterprise extends Model
{
    use HasFactory;

    protected $table = 'enterprise';

    protected $fillable = [
        'name', 'contactName', 'phoneContact',
        'emailContact', 'bussinesLine_id'
    ];

    protected $primaryKey = 'id';

    protected $hidden = ['bussinesLine_id'];

    public function bussinesLine(): BelongsTo
    {
        return $this->belongsTo(BussinesLine::class, 'bussinesLine_id');
    }

    public $timestamps = false;
}
