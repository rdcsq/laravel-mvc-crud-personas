<x-layout>
    <div class="flex items-center justify-center min-h-svh w-full">
        <div class="max-w-xl w-full bg-white rounded-lg shadow-lg px-6 py-4 relative">
            <a href="/" class="absolute"><p class="font-bold text-lg">⬅️</p></a>

            @if (isset($persona))
                <form method="post" class="absolute right-6" id="eliminar-form">
                    @method('DELETE')
                    @csrf
                    <button type="submit" name="eliminar">🗑️</button>
                </form>
            @endif

            <h1 class="text-center font-bold text-2xl pt-2 pb-4">
                {{ isset($persona) ? "Modificar" : "Agregar" }}
            </h1>

            @if (session()->has('success'))
                <p class="bg-green-200 border border-green-300 px-4 py-2 rounded-lg mt-4">
                    {{ session()->get('success') }}
                </p>
            @endif

            <form method="post" class="mt-2" id="form">
                @csrf
                <div class="form two-cols">
                    <label for="rfc">RFC</label>
                    <input type="text" id="rfc" name="rfc" placeholder="RFC"
                           value="{{ old('rfc') ?? $persona?->rfc ?? "" }}" @readonly(isset($persona))/>
                    @if ($errors->has('rfc'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('rfc') }}</p>
                    @endif

                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre"
                           value="{{ old('nombre') ?? $persona?->nombre ?? "" }}"/>
                    @if ($errors->has('nombre'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('nombre') }}</p>
                    @endif

                    <label for="calle">Calle</label>
                    <input type="text" id="calle" name="calle" placeholder="Calle"
                           value="{{ old('calle') ?? $persona?->domicilio->calle ?? "" }}"/>
                    @if ($errors->has('calle'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('calle') }}</p>
                    @endif

                    <label for="numero">Número</label>
                    <input type="number" id="numero" name="numero" placeholder="Número"
                           value="{{ old('numero') ?? $persona?->domicilio->numero ?? "" }}"/>
                    @if ($errors->has('numero'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('numero') }}</p>
                    @endif

                    <label for="colonia">Colonia</label>
                    <input type="text" id="colonia" name="colonia" placeholder="Colonia"
                           value="{{ old('colonia') ?? $persona?->domicilio->colonia ?? "" }}"/>
                    @if ($errors->has('colonia'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('colonia') }}</p>
                    @endif

                    <label for="cp">Código Postal</label>
                    <input type="number" min="0" max="99999" id="cp" name="cp" placeholder="Código Postal"
                           value="{{ old('cp') ?? $persona?->domicilio->cp ?? "" }}"/>
                    @if ($errors->has('cp'))
                        <p class="text-red-500 text-sm col-2">{{ $errors->first('cp') }}</p>
                    @endif
                </div>

                <div class="flex justify-end items-center gap-2 mt-4">
                    <button type="submit" class="btn">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        /**
         * @type {HTMLFormElement}
         */
        const form = document.querySelector('#eliminar-form')

        form.addEventListener('submit', (e) => {
            if (!confirm('¿Está seguro de eliminar a esta persona?')) {
                e.preventDefault();
            }
        })
    </script>
</x-layout>
