<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'max' => ['string' => 'El campo :attribute no puede superar los :max caracteres.'],
    'numeric' => 'El campo :attribute debe ser un número.',
    'date' => 'El campo :attribute debe ser una fecha válida.',
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'image' => 'El archivo :attribute debe ser una imagen.',
    'mimes' => 'El archivo :attribute debe ser de tipo: :values.',
    'js' => [
        'required' => 'Este campo es obligatorio.',
        'email' => 'Introduce una dirección de correo electrónico válida.',
        'numeric' => 'Solo se permiten números.',
        'selected' => 'Selecciona una opción.',
    ],
    'attributes' => [],
];
