<?php

namespace App\Services\Personas\Dto;
use App\Entities\Persona;

readonly class ListarPersonasDto
{
    public function __construct(
        private array $personas,
        private int   $cantidad
    )
    {
    }

    /**
     * @return Persona[]
     */
    public function getPersonas(): array
    {
        return $this->personas;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }
}
