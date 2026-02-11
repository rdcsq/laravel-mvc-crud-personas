<?php

namespace App\Entities;

use App\Models\Persona as PersonaDataModel;

class Persona
{
    public function __construct(
        private string    $rfc,
        private string    $nombre,
        private Domicilio $domicilio
    )
    {
    }

    public function getRfc(): string
    {
        return $this->rfc;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDomicilio(): Domicilio
    {
        return $this->domicilio;
    }
}
