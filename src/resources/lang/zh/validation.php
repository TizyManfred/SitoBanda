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

    'required' => ':attribute字段是必填的。',
    'string' => ':attribute字段必须是字符串。',
    'max' => [
        'string' => ':attribute字段不能超过 :max 个字符。',
    ],
    'numeric' => ':attribute字段必须是数字。',
    'date' => ':attribute字段必须是有效的日期。',
    'email' => ':attribute字段必须是有效的电子邮件地址。',
    'image' => ':attribute文件必须是图片。',
    'mimes' => ':attribute文件的类型必须是：:values。',
    
    // JavaScript form validation messages
    'js' => [
        'required' => '此字段为必填项。',
        'email' => '请输入有效的电子邮件地址。',
        'numeric' => '仅允许输入数字。',
        'selected' => '请选择一个选项。',
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
