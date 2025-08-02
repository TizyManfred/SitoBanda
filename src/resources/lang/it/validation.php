<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'required' => 'Il campo :attribute è obbligatorio.',
    'string' => 'Il campo :attribute deve essere una stringa.',
    'max' => [
        'string' => 'Il campo :attribute non può superare :max caratteri.',
    ],
    'numeric' => 'Il campo :attribute deve essere un numero.',
    'date' => 'Il campo :attribute deve essere una data valida.',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido.',
    'image' => 'Il file :attribute deve essere un\'immagine.',
    'mimes' => 'Il file :attribute deve essere di tipo: :values.',
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [],
];
