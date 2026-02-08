<x-layout>
    <div>
        <div class="px-6 pt-4">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-3xl">Personas</h1>

                <div>
                    <form class="form inline-flex gap-2" id="buscar">
                        <input type="text" id="rfc" name="rfc" placeholder="RFC" class="grow bg-white"/>
                        <button type="submit" class="btn">🔍</button>
                    </form>
                    <a href="/agregar" class="btn inline-block ml-4">
                        Agregar
                    </a>
                </div>
            </div>

            @if (session()->has('error'))
                <p class="bg-red-200 border border-red-300 px-4 py-2 rounded-lg mt-4">
                    {{ session()->get('error') }}
                </p>
            @endif

            @if (session()->has('success'))
                <p class="bg-green-200 border border-green-300 px-4 py-2 rounded-lg mt-4">
                    {{ session()->get('success') }}
                </p>
            @endif
        </div>

        <div class="bg-white rounded-t-4xl overflow-clip overflow-y-auto h-full mt-4 border-t-blue-200 border-t-2">
            <table>
                <thead>
                <th>RFC</th>
                <th>Nombre</th>
                <th>Calle</th>
                <th>Número</th>
                <th>Colonia</th>
                <th>CP</th>
                <th class="w-0"></th>
                </thead>
                <tbody>
                @foreach ($personas as $persona)
                    <tr>
                        <td>{{ $persona->rfc }}</td>
                        <td>{{ $persona->nombre }}</td>
                        <td>{{ $persona->domicilio?->calle }}</td>
                        <td>{{ $persona->domicilio?->numero }}</td>
                        <td>{{ $persona->domicilio?->colonia }}</td>
                        <td>{{ $persona->domicilio?->cp }}</td>
                        <td>
                            <a href="/{{ $persona->rfc }}">
                                <button type="submit">✏️</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="flex justify-end items-center px-4 py-2">
                <span>Límite:</span>
                <form method="get">
                    <input hidden name="pagina" value="1">
                    <select class="py-2.5! ml-2 mr-6 btn" name="limite" id="limite">
                        <option value="10" @selected($limite == 10)>10</option>
                        <option value="25" @selected($limite == 25)>25</option>
                        <option value="50" @selected($limite == 50)>50</option>
                    </select>
                </form>
                <form method="get">
                    <input hidden name="limite" value="{{ $limite }}">
                    <input type="hidden" name="pagina" value="{{ $pagina - 1 }}">
                    <button type="submit" class="btn" @disabled($pagina == 1)>&lt;</button>
                </form>
                <form method="get">
                    <input hidden name="limite" value="{{ $limite }}">
                    <select class="py-2.5! mx-2 btn" id="pagina" name="pagina">
                        @for($i = 1; $i <= $paginas; $i++)
                            <option value="{{ $i }}" @selected($pagina == $i)>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
                <form method="get">
                    <input hidden name="limite" value="{{ $limite }}">
                    <input type="hidden" name="pagina" value="{{ $pagina + 1 }}">
                    <button type="submit" class="btn" @disabled($pagina == $paginas)>&gt;</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script>
    const form = document.querySelector('#buscar');

    /**
     * @type {HTMLInputElement}
     */
    const rfc = document.querySelector('#rfc')

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (rfc.value.trim() === '') return;
        window.location.href = `/${rfc.value}`;
    })

    function submitAlCambiarSelect(selectQuerySelector) {
        /**
         * @type {HTMLSelectElement}
          */
        const select = document.querySelector(selectQuerySelector)

        select.addEventListener('change', () => {
            select.form.submit();
        })
    }

    submitAlCambiarSelect('#limite');
    submitAlCambiarSelect('#pagina');
</script>
