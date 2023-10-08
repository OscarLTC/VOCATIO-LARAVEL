<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'name', 'lastName', 'emailAddress',
        'docType_id', 'docNumber', 'phoneNumber', 'enterprise_id'
    ];

    protected $hidden = ['docType_id', 'enterprise_id'];

    protected $primaryKey = 'id';

    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocType::class, 'docType_id');
    }

    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id');
    }


    public $timestamps = false;
}
