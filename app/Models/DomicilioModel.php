<?php

namespace App\Models;

use App\Entities\Persona;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomicilioModel extends Model
{
    /** @use HasFactory<\Database\Factories\DomicilioModelFactory> */
    use HasFactory;

    protected $table = 'domicilios';
    protected $primaryKey = 'rfc';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['calle', 'numero', 'colonia', 'cp'];

    public function persona(): BelongsTo {
        return $this->belongsTo(PersonaModel::class, 'rfc', 'rfc');
    }
}
