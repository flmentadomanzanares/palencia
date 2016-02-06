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

	"accepted"             => "El campo :attribute debe ser aceptado.",
	"active_url"           => "El campo :attribute no es una URL válida.",
	"after"                => "El campo :attribute debe ser una fecha posterior a :date.",
	"alpha"                => "El campo :attribute es alfabético.",
	"alpha_dash"           => "El campo :attribute es alfanumético con guiones.",
	"alpha_num"            => "El campo :attribute es alfanumérico.",
	"array"                => "El campo :attribute debe ser un array.",
	"before"               => "El campo :attribute debe ser una fecha anterior a :date.",
	"between"              => [
		"numeric" => "El campo :attribute debe de estar entre :min and :max.",
		"file"    => "El campo :attribute debe de estar entre :min and :max kilobytes.",
		"string"  => "El campo :attribute de estar entre :min and :max caracteres.",
		"array"   => "El campo :attribute de estar entre :min and :max elementos.",
	],
	"boolean"              => "El campo :attribute es verdadero o falso.",
		"confirmed" => "El campo :attribute ha fallado al verificarse.",
	"date"                 => "El campo :attribute es una fecha no válida.",
	"date_format"          => "El campo :attribute no tiene el formato :format.",
	"different"            => "El campo :attribute y :other debe ser diferentes.",
	"digits"               => "El campo :attribute debe ser :digits dígitos.",
	"digits_between"       => "El campo :attribute debe de estar entre :min and :max dígitos.",
	"email"                => "El campo :attribute debe ser una dirección de email válida.",
	"filled"               => "El campo :attribute es reqeridois.",
	"exists"               => "El campo seleccionado :attribute no es válido.",
	"image"                => "El campo :attribute debe ser una imagen.",
	"in"                   => "El campo seleccionado :attribute no es válido.",
	"integer"              => "El campo :attribute debe ser un entero.",
	"ip"                   => "El campo :attribute debe ser un dirección IP.",
	"max"                  => [
		"numeric" => "El campo :attribute no debe ser mayor que :max.",
		"file"    => "El campo :attribute no debe ser mayor que :max kilobytes.",
		"string"  => "El campo :attribute no debe ser mayor de :max caracteres.",
		"array"   => "El campo :attribute no debe tener mas de :max elementos.",
	],
	"mimes"                => "El campo :attribute debe ser a archivo del tipo :values.",
	"min"                  => [
		"numeric" => "El campo :attribute no debe ser menor que :min.",
		"file"    => "El campo :attribute no debe ser menor que :min kilobytes.",
		"string"  => "El campo :attribute no debe ser menor de :min caracteres.",
		"array"   => "El campo :attribute no debe tener menos de :min elementos.",
	],
	"not_in"               => "El campo seleccionado :attribute no es válido.",
	"numeric"              => "El campo :attribute debe ser un número.",
	"regex"                => "El campo :attribute tiene un formato no válido.",
	"required"             => "El campo :attribute es requerido.",
	"required_if"          => "El campo :attribute es requerido cuando :other es :value.",
	"required_with"        => "El campo :attribute es requerido cuando :values está presente.",
	"required_with_all"    => "El campo :attribute es requerido cuando :values está presente.",
	"required_without"     => "El campo :attribute es requerido cuando :values no está presente.",
	"required_without_all" => "El campo :attribute es requerido cuando ningún :values está presente.",
	"same"                 => "El campo :attribute y :other deben de coincidir.",
	"size"                 => [
		"numeric" => "El campo :attribute debe ser de :size.",
		"file"    => "El campo :attribute debe ser de :size kilobytes.",
		"string"  => "El campo :attribute debe ser de :size caracteres.",
		"array"   => "El campo :debe de contener  :size elementos.",
	],
	"unique"               => "El campo :attribute ya existe.",
	"url"                  => "El campo :attribute no tiene el formato válido.",
	"timezone"             => "El campo :attribute debe ser una zona horaria válida.",

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
