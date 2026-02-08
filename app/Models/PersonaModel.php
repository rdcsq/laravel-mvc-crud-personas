<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonaModel extends Model
{
    /** @use HasFactory<\Database\Factories\PersonaModelFactory> */
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'rfc';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function domicilio(): HasOne {
        return $this->hasOne(DomicilioModel::class, 'rfc', 'rfc');
    }
}
