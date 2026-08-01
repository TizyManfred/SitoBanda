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

    'required' => 'Поле :attribute обязательно для заполнения.',
    'string' => 'Поле :attribute должно быть строкой.',
    'max' => [
        'string' => 'Поле :attribute не может содержать более :max символов.',
    ],
    'numeric' => 'Поле :attribute должно быть числом.',
    'date' => 'Поле :attribute должно быть действительной датой.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'image' => 'Файл :attribute должен быть изображением.',
    'mimes' => 'Файл :attribute должен иметь тип: :values.',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'Это поле обязательно для заполнения.',
        'email' => 'Введите действительный адрес электронной почты.',
        'numeric' => 'Допускаются только числа.',
        'selected' => 'Выберите вариант.',
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
