<?php

namespace App\Entities;

use App\Models\PersonaModel;

class Persona
{
    public function __construct(
        public private(set) string    $rfc,
        public private(set) string    $nombre,
        public private(set) Domicilio $domicilio
    )
    {
    }

    public static function fromModel(PersonaModel $personaModel): self
    {
        return new self(
            $personaModel['rfc'],
            $personaModel['nombre'],
            Domicilio::fromModel($personaModel['domicilio'])
        );
    }
}
