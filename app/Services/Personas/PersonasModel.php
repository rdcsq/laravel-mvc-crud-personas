<?php

namespace App\Services\Personas;

use App\Entities\Persona;
use App\Services\Personas\Dto\ListarPersonasDto;

readonly class PersonasModel
{
    public function __construct(
        private PersonasService $personasService
    )
    {
    }

    public function listar(int $page, int $limite): ListarPersonasDto
    {
        return $this->personasService->listar($page, $limite);
    }

    public function recuperar(string $rfc): ?Persona
    {
        return $this->personasService->recuperar($rfc);
    }

    public function guardar(Persona $persona): bool
    {
        return $this->personasService->guardar($persona);
    }

    public function actualizar(Persona $persona): bool
    {
        return $this->personasService->actualizar($persona);
    }

    public function eliminar(string $rfc): bool
    {
        return $this->personasService->eliminar($rfc);
    }
}
