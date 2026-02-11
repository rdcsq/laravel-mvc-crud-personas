<?php

namespace App\Http\Controllers;

use App\Entities\Domicilio;
use App\Entities\Persona;
use App\Http\Requests\ActualizarPersonaRequest;
use App\Http\Requests\CrearPersonaRequest;
use App\Services\Personas\PersonasModel;
use App\Services\Personas\PersonasService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PersonaController extends Controller
{
    public function __construct(
        private readonly PersonasModel $personasModel
    )
    {
    }

    public function index(Request $request): View
    {
        $pagina = $request->query('pagina', 1) - 1;
        $limite = $request->query('limite', 10);
        $listarPersonasDto = $this->personasModel->listar(
            $pagina,
            $limite
        );
        return view('index', [
            'personas' => $listarPersonasDto->getPersonas(),
            'paginas' => ceil($listarPersonasDto->getCantidad() / $limite),
            'pagina' => $pagina + 1,
            'limite' => $limite
        ]);
    }

    public function recuperar(string $rfc): View|RedirectResponse
    {
        $persona = $this->personasModel->recuperar($rfc);

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

        $success = $this->personasModel->guardar(new Persona(
            $validated['rfc'],
            $validated['nombre'],
            new Domicilio(
                $validated['calle'],
                $validated['numero'],
                $validated['colonia'],
                $validated['cp']
            )
        ));

        return $success
            ? redirect('/')->with('success', 'Persona agregada exitosamente')
            : redirect('/')->with('error', 'Ocurrió un error al agregar persona');
    }

    public function eliminar(string $rfc): RedirectResponse
    {
        $success = $this->personasModel->eliminar($rfc);

        return $success
            ? redirect('/')->with('success', 'Persona eliminada exitosamente')
            : redirect('/')->with('error', 'Ocurrió un error al eliminar persona');
    }

    public function editar(ActualizarPersonaRequest $request, string $rfc): RedirectResponse
    {
        $validated = $request->validated();

        $success = $this->personasModel->actualizar(
            new Persona(
                $rfc,
                $validated['nombre'],
                new Domicilio(
                    $validated['calle'],
                    $validated['numero'],
                    $validated['colonia'],
                    $validated['cp']
                )
            )
        );

        return $success
            ? redirect('/' . $rfc)->with('success', 'Persona actualizada exitosamente')
            : redirect('/' . $rfc)->with('error', 'Ocurrió un error al actualizar persona');
    }
}
