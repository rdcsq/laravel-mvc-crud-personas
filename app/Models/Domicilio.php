<?php

namespace App\Models;

use App\Entities\Persona;
use Database\Factories\DomicilioFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domicilio extends Model
{
    /** @use HasFactory<DomicilioFactory> */
    use HasFactory;

    protected $table = 'domicilios';
    protected $primaryKey = 'rfc';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['calle', 'numero', 'colonia', 'cp'];

    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'rfc', 'rfc');
    }
}
