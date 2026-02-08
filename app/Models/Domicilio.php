<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domicilio extends Model
{
    /** @use HasFactory<\Database\Factories\DomicilioFactory> */
    use HasFactory;

    protected $primaryKey = 'rfc';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['calle', 'numero', 'colonia', 'cp'];

    public function persona(): BelongsTo {
        return $this->belongsTo(Persona::class, 'rfc', 'rfc');
    }
}
