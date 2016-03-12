<?php namespace Palencia\Http\Requests;

class ValidateRulesComunidades extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //Cambiarlo a true para cualquier usuario o invitado sólo para autentificados false
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "year" => "required|integer|min:1900|max:2050",
            "fecha_inicio" => "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "fecha_final" => "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "semana_no" => "required|integer|min:1|max:53",
            "activo" => "boolean"
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'year.required' => 'El año es obligatorio!',
            'year.integer' => 'El año debe ser un numero entero!',
            'year.min' => 'El valor mínimo del año es :min',
            'year.max' => 'El valor máximo del año es :max',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria!',
            'fecha_inicio.date_format' => 'La fecha de inicio debe ser una fecha del tipo día/mes/año',
            'fecha_final.required' => 'La fecha final es obligatoria!',
            'fecha_final.date_format' => 'La fecha final debe ser una fecha del tipo día/mes/año',
            'semana_no.required' => 'El campo semana nº es obligatorio!',
            'semana_no.integer' => 'El campo semana nº debe ser un numero entero!',
            'semana_no.min' => 'El valor mínimo del campo semana nº es :min',
            'semana_no.max' => 'El valor máximo del campo semana nº es :max',
            'activo.required' => 'El campo tutor es obligatorio!',
            'activo.boolean' => 'El valor del campo tutor debe ser No o Si'
        ];
    }

}
