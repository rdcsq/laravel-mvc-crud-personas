<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPersonaRequest;
use App\Http\Requests\CrearPersonaRequest;
use App\Models\Persona;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class PersonaController extends Controller
{
    public function index(): View
    {
        return view('index', [
            'personas' => Persona::with('domicilio')->orderBy('personas.rfc')->get()
        ]);
    }

    public function recuperar(string $rfc): View|RedirectResponse
    {
        $persona = Persona::with('domicilio')->where('rfc', $rfc)->first();

        if ($persona === null) {
            return redirect('/')->with('error', 'Persona no encontrada');
        }

        return view('formulario-persona', [
            'persona' => $persona
        ]);
    }

    public function mostrarFormularioAgregar(): View
    {
        return view('formulario-persona');
    }

    public function agregar(CrearPersonaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                DB::table('personas')->insert([
                    'rfc' => $validated['rfc'],
                    'nombre' => $validated['nombre']
                ]);

                DB::table('domicilios')->insert([
                    'rfc' => $validated['rfc'],
                    'calle' => $validated['calle'],
                    'numero' => $validated['numero'],
                    'colonia' => $validated['colonia'],
                    'cp' => $validated['cp'],
                ]);
            });

            return redirect('/')->with('success', 'Persona agregada exitosamente');
        } catch (Throwable $e) {
            report($e);
            return redirect('/')->with('error', 'Ocurrió un error al agregar persona');
        }
    }

    public function eliminar(string $rfc): RedirectResponse
    {
        try {
            $eliminado = DB::table('personas')->where('rfc', $rfc)->delete();

            if ($eliminado === 0) {
                return redirect('/')->with('error', 'Persona no encontrada');
            }

            return redirect('/')->with('success', 'Persona eliminada exitosamente');
        } catch (Throwable $e) {
            report($e);
            return redirect('/')->with('error', 'Ocurrió un error al eliminar persona');
        }
    }

    public function editar(ActualizarPersonaRequest $request, string $rfc): RedirectResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated, $rfc) {
                DB::table('personas')->where('rfc', $rfc)->update([
                    'nombre' => $validated['nombre']
                ]);

                DB::table('domicilios')->where('rfc', $rfc)->update([
                    'calle' => $validated['calle'],
                    'numero' => $validated['numero'],
                    'colonia' => $validated['colonia'],
                    'cp' => $validated['cp']
                ]);
            });

            return redirect('/' . $rfc)->with('success', 'Persona actualizada exitosamente');
        } catch (Throwable $e) {
            report($e);
            return redirect('/' . $rfc)->with('error', 'Ocurrió un error al actualizar persona');
        }
    }
}
