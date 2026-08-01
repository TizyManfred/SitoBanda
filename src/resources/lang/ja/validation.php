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

    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列でなければなりません。',
    'max' => [
        'string' => ':attributeは:max文字を超えることはできません。',
    ],
    'numeric' => ':attributeは数値でなければなりません。',
    'date' => ':attributeは有効な日付でなければなりません。',
    'email' => ':attributeは有効なメールアドレスでなければなりません。',
    'image' => ':attributeは画像ファイルでなければなりません。',
    'mimes' => ':attributeは次の種類のファイルである必要があります：:values。',
    
    // JavaScript form validation messages
    'js' => [
        'required' => 'この項目は必須です。',
        'email' => '有効なメールアドレスを入力してください。',
        'numeric' => '数字のみ入力できます。',
        'selected' => 'いずれかを選択してください。',
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
