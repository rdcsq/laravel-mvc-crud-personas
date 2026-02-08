<?php

namespace App\Services;

use App\Entities\Persona;
use App\Models\PersonaModel;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class PersonasService
{
    public function __construct(
        private PersonaModel $personaModel
    )
    {
    }

    public function listar(int $page = 1, int $limite = 10): array
    {
        $query = $this->personaModel::with('domicilio')
            ->select('*')
            ->selectRaw('count(*) over () as cantidad')
            ->orderBy('personas.rfc')
            ->offset($page * $limite)
            ->limit($limite)
            ->get();

        return [
            'personas' => $query->map(fn(PersonaModel $persona) => Persona::fromModel($persona))->toArray(),
            'cantidad' => $query->first()['cantidad'] ?? 0
        ];
    }

    public function recuperar(string $rfc): ?Persona
    {
        $persona = $this->personaModel::with('domicilio')
            ->where('rfc', $rfc)
            ->first();

        if ($persona === null) {
            return null;
        }

        return Persona::fromModel($persona);
    }

    /**
     * @param Persona $persona
     * @return bool Exito/fallo al guardar persona
     */
    public function guardar(Persona $persona): bool
    {
        try {
            DB::transaction(function () use ($persona) {
                DB::table('personas')->insert([
                    'rfc' => $persona->rfc,
                    'nombre' => $persona->nombre,
                ]);

                DB::table('domicilios')->insert([
                    'rfc' => $persona->rfc,
                    'calle' => $persona->domicilio->calle,
                    'numero' => $persona->domicilio->numero,
                    'colonia' => $persona->domicilio->colonia,
                    'cp' => $persona->domicilio->cp,
                ]);
            });

            return true;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param Persona $persona
     * @return bool Éxito/fallo al actualizar persona
     */
    public function actualizar(Persona $persona): bool
    {
        try {
            DB::transaction(function () use ($persona) {
                DB::table('personas')->where('rfc', $persona->rfc)->update([
                    'nombre' => $persona->nombre
                ]);

                DB::table('domicilios')->where('rfc', $persona->rfc)->update([
                    'calle' => $persona->domicilio->calle,
                    'numero' => $persona->domicilio->numero,
                    'colonia' => $persona->domicilio->colonia,
                    'cp' => $persona->domicilio->cp
                ]);
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
            $eliminado = DB::table('personas')->where('rfc', $rfc)->delete();
            return $eliminado > 0;
        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }
}
