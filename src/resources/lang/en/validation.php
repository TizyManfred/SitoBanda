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

    'required' => 'The :attribute field is required.',
    'string' => 'The :attribute field must be a string.',
    'max' => [
        'string' => 'The :attribute field may not be greater than :max characters.',
    ],
    'numeric' => 'The :attribute field must be a number.',
    'date' => 'The :attribute field must be a valid date.',
    'email' => 'The :attribute field must be a valid email address.',
    'image' => 'The :attribute file must be an image.',
    'mimes' => 'The :attribute file must be a file of type: :values.',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'This field is required.',
        'email' => 'Please enter a valid email address.',
        'numeric' => 'Only numbers are allowed.',
        'selected' => 'Please choose an option.',
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
