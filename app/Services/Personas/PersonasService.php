<?php

namespace App\Services\Personas;

use App\Entities\Domicilio;
use App\Entities\Persona;
use Illuminate\Support\Facades\DB;
use App\Services\Personas\Dto\ListarPersonasDto;
use Throwable;
use App\Models\Persona as PersonaDataModel;
use App\Models\Domicilio as DomicilioDataModel;

readonly class PersonasService
{
    public function __construct(
        private PersonaDataModel $personaDataModel
    )
    {
    }

    /**
     * @param int $page Página (índice 0)
     * @param int $limite
     * @return ListarPersonasDto
     */
    public function listar(int $page, int $limite): ListarPersonasDto
    {
        $data = $this->personaDataModel::with('domicilio')
            ->select('*')
            ->selectRaw('count(*) over () as cantidad')
            ->orderBy('personas.rfc')
            ->offset($page * $limite)
            ->limit($limite)
            ->get();

        $personas = $data->map(function(PersonaDataModel $p) {
            $d = $p->domicilio;

            return new Persona(
                $p->rfc,
                $p->nombre,
                new Domicilio(
                    $d->calle,
                    $d->numero,
                    $d->colonia,
                    $d->cp
                )
            );
        })->toArray();
        $cantidad = $data->first()?->cantidad ?? 0;

        return new ListarPersonasDto($personas, $cantidad);
    }

    public function recuperar(string $rfc): ?Persona
    {
        $p = $this->personaDataModel::with('domicilio')
            ->where('rfc', $rfc)
            ->first();

        if ($p == null) {
            return null;
        }

        return new Persona(
            $p->rfc,
            $p->nombre,
            new Domicilio(
                $p->domicilio->calle,
                $p->domicilio->numero,
                $p->domicilio->colonia,
                $p->domicilio->cp
            )
        );
    }

    /**
     * @return bool Exito/fallo al guardar persona
     */
    public function guardar(Persona $persona): bool
    {
        try {
            DB::transaction(function () use ($persona) {
                $personaModel = new PersonaDataModel([
                    'nombre' => $persona->getNombre(),
                ]);
                $personaModel->rfc = strtoupper($persona->getRfc());
                $personaModel->save();

                $domicilioModel = new DomicilioDataModel([
                    'calle' => $persona->getDomicilio()->getCalle(),
                    'numero' => $persona->getDomicilio()->getNumero(),
                    'colonia' => $persona->getDomicilio()->getColonia(),
                    'cp' => $persona->getDomicilio()->getCodigoPostal()
                ]);
                $personaModel->domicilio()->save($domicilioModel);
            });

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * @return bool Éxito/fallo al actualizar persona
     */
    public function actualizar(Persona $persona): bool
    {
        try {
            DB::transaction(function () use ($persona) {
                $personaModel = PersonaDataModel::with('domicilio')->find($persona->getRfc());
                $personaModel->update([
                    'nombre' => $persona->getNombre(),
                ]);
                $personaModel->save();

                $personaModel->domicilio->update([
                    'calle' => $persona->getDomicilio()->getCalle(),
                    'numero' => $persona->getDomicilio()->getNumero(),
                    'colonia' => $persona->getDomicilio()->getColonia(),
                    'cp' => $persona->getDomicilio()->getCodigoPostal(),
                ]);
                $personaModel->domicilio->save();
            });

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param string $rfc
     * @return bool Éxito/fallo al eliminar persona
     */
    public function eliminar(string $rfc): bool
    {
        try {
            return PersonaDataModel::where('rfc', $rfc)->delete() ?? false;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
