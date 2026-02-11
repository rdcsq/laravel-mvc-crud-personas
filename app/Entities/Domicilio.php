<?php

namespace App\Entities;

class Domicilio
{
    public function __construct(
        private string $calle,
        private int    $numero,
        private string $colonia,
        private int    $cp)
    {
    }

    public function getCalle(): string
    {
        return $this->calle;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getColonia(): string
    {
        return $this->colonia;
    }

    public function getCodigoPostal(): int
    {
        return $this->cp;
    }
}
