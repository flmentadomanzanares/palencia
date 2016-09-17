<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    "accepted" => ":attribute debe ser aceptado.",
    "active_url" => ":attribute no es una URL válida.",
    "after" => ":attribute debe ser una fecha posterior a :date.",
    "alpha" => ":attribute es alfabético.",
    "alpha_dash" => ":attribute es alfanumético con guiones.",
    "alpha_num" => ":attribute es alfanumérico.",
    "array" => ":attribute debe ser un array.",
    "before" => ":attribute debe ser una fecha anterior a :date.",
    "between" => [
        "numeric" => ":attribute debe de estar entre :min and :max.",
        "file" => ":attribute debe de estar entre :min and :max kilobytes.",
        "string" => ":attribute de estar entre :min and :max caracteres.",
        "array" => ":attribute de estar entre :min and :max elementos.",
    ],
    "boolean" => ":attribute es verdadero o falso.",
    "confirmed" => ":attribute ha fallado al verificarse.",
    "date" => ":attribute es una fecha no válida.",
    "date_format" => ":attribute no tiene el formato :format.",
    "different" => ":attribute y :other debe ser diferentes.",
    "digits" => ":attribute debe ser :digits dígitos.",
    "digits_between" => ":attribute debe de estar entre :min and :max dígitos.",
    "email" => ":attribute debe ser una dirección válida.",
    "filled" => ":attribute debe de llenarse.",
    "exists" => ":attribute no es válido.",
    "image" => ":attribute debe ser una imagen.",
    "in" => ":attribute no es válido.",
    "integer" => ":attribute debe ser un entero.",
    "ip" => ":attribute debe ser un dirección IP.",
    "max" => [
        "numeric" => ":attribute no debe ser mayor que :max.",
        "file" => ":attribute no debe ser mayor que :max kilobytes.",
        "string" => ":attribute no debe ser mayor de :max caracteres.",
        "array" => ":attribute no debe tener mas de :max elementos.",
    ],
    "mimes" => ":attribute debe ser a archivo del tipo :values.",
    "min" => [
        "numeric" => ":attribute no debe ser menor que :min.",
        "file" => ":attribute no debe ser menor que :min kilobytes.",
        "string" => ":attribute no debe ser menor de :min caracteres.",
        "array" => ":attribute no debe tener menos de :min elementos.",
    ],
    "not_in" => ":attribute no es válido.",
    "numeric" => ":attribute debe ser un número.",
    "regex" => ":attribute tiene un formato no válido.",
    "required" => ":attribute es requerido.",
    "required_if" => ":attribute es requerido cuando :other es :value.",
    "required_with" => ":attribute es requerido cuando :values está presente.",
    "required_with_all" => ":attribute es requerido cuando :values está presente.",
    "required_without" => ":attribute es requerido cuando :values no está presente.",
    "required_without_all" => ":attribute es requerido cuando ningún :values está presente.",
    "same" => ":attribute y :other deben de coincidir.",
    "size" => [
        "numeric" => ":attribute debe ser de :size.",
        "file" => ":attribute debe ser de :size kilobytes.",
        "string" => ":attribute debe ser de :size caracteres.",
        "array" => ":debe de contener  :size elementos.",
    ],
    "unique" => ":attribute ya existe.",
    "url" => ":attribute no tiene el formato válido.",
    "timezone" => ":attribute debe ser una zona horaria válida.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
