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

    'required' => 'Das Feld :attribute ist erforderlich.',
    'string' => 'Das Feld :attribute muss eine Zeichenkette sein.',
    'max' => [
        'string' => 'Das Feld :attribute darf nicht mehr als :max Zeichen haben.',
    ],
    'numeric' => 'Das Feld :attribute muss eine Zahl sein.',
    'date' => 'Das Feld :attribute muss ein gültiges Datum sein.',
    'email' => 'Das Feld :attribute muss eine gültige E-Mail-Adresse sein.',
    'image' => 'Die Datei :attribute muss ein Bild sein.',
    'mimes' => 'Die Datei :attribute muss vom Typ: :values sein.',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'Dieses Feld ist erforderlich.',
        'email' => 'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
        'numeric' => 'Nur Zahlen sind erlaubt.',
        'selected' => 'Bitte wählen Sie eine Option.',
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
