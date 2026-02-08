<?php

namespace App\Entities;

use App\Models\DomicilioModel;

class Domicilio
{
    public function __construct(
        public private(set) string $calle,
        public private(set) int    $numero,
        public private(set) string $colonia,
        public private(set) int    $cp)
    {
    }

    public static function fromModel(DomicilioModel $domicilioModel): self
    {
        return new self(
            $domicilioModel['calle'],
            $domicilioModel['numero'],
            $domicilioModel['colonia'],
            $domicilioModel['cp']
        );
    }
}
