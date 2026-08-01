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

    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser uma string.',
    'max' => [
        'string' => 'O campo :attribute não pode exceder :max caracteres.',
    ],
    'numeric' => 'O campo :attribute deve ser um número.',
    'date' => 'O campo :attribute deve ser uma data válida.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'image' => 'O arquivo :attribute deve ser uma imagem.',
    'mimes' => 'O arquivo :attribute deve ser do tipo: :values.',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'Este campo é obrigatório.',
        'email' => 'Insira um endereço de e-mail válido.',
        'numeric' => 'Apenas números são permitidos.',
        'selected' => 'Selecione uma opção.',
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
