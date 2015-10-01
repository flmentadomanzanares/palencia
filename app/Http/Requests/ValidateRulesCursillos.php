<?php namespace Palencia\Http\Requests;

use Palencia\Http\Requests\Request;

class ValidateRulesCursillos extends Request {

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
            "cursillo"    =>    "required|min:2|max:50",
            "fecha_inicio"    =>    "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "fecha_final"    =>    "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "descripcion" => "required|min:20",
            "comunidad_id"    =>    "required",
            "activo"    =>    "boolean"
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'cursillo.required' => 'El cursillo es obligatorio.',
            'cursillo.min' => 'Longitud mínima del cursillo :min caracteres.',
            'cursillo.max' => 'Longitud máxima del cursillo :max caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria!',
            'fecha_inicio.date_format' => 'La fecha de inicio debe ser una fecha del tipo día/mes/año',
            'fecha_final.required' => 'La fecha final es obligatoria!',
            'fecha_final.date_format' => 'La fecha final debe ser una fecha del tipo día/mes/año',
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.min' => 'Longitud mínima de la descripción :min caracteres.',
            'comunidad_id.required' => "Debes de elegir una comunidad.",
            'activo.boolean' => 'El valor del campo activo debe ser No o Si'
        ];
    }

}
