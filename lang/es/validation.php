<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string'   => 'El campo :attribute debe ser una cadena de texto.',
    'integer'  => 'El campo :attribute debe ser un número entero.',
    'min'      => [
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser al menos :min.',
    ],
    'max'      => [
        'string'  => 'El campo :attribute no debe exceder :max caracteres.',
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
    ],
    'exists'   => 'El :attribute seleccionado no es válido.',
    'regex'    => 'El formato de :attribute no es válido.',
    'unique'   => 'Un registro con el :attribute especificado ya existe.',
    'digits'   => 'El campo :attribute debe tener :digits dígitos.',

    'attributes' => [
        'rfc'     => 'RFC',
        'nombre'  => 'nombre',
        'calle'   => 'calle',
        'numero'  => 'número',
        'colonia' => 'colonia',
        'cp'      => 'código postal',
    ],
];
