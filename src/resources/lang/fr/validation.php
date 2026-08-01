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

    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'max' => [
        'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
    ],
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'date' => 'Le champ :attribute doit être une date valide.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'image' => 'Le fichier :attribute doit être une image.',
    'mimes' => 'Le fichier :attribute doit être de type :values.',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'Ce champ est obligatoire.',
        'email' => 'Saisissez une adresse e-mail valide.',
        'numeric' => 'Seuls les nombres sont autorisés.',
        'selected' => 'Sélectionnez une option.',
    ],
    
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
