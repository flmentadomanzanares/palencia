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
            "cursillo"    =>    "max:50",
            "num_cursillo"    =>    "numeric",
            "fecha_inicio"    =>    "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "fecha_final"    =>    "required|date_format:d/m/Y|regex:/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/",
            "descripcion" => "min:20",
            "comunidad_id"    =>    "required|numeric|min:1",
            "tipo_participante_id"    =>    "required|numeric|min:1",
            "activo"    =>    "boolean"
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo

            'cursillo.max' => 'Longitud máxima del cursillo :max caracteres.',
            'num_cursillo.numeric'=>'El número del cursillo debe de ser numérico.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria!',
            'fecha_inicio.date_format' => 'La fecha de inicio debe ser una fecha del tipo día/mes/año',
            'fecha_final.required' => 'La fecha final es obligatoria!',
            'fecha_final.date_format' => 'La fecha final debe ser una fecha del tipo día/mes/año',
            'descripcion.min' => 'Longitud mínima de la descripción :min caracteres.',
            'comunidad_id.required' => "La comunidad es obligatoria.",
            'comunidad_id.min' => "Debes de elegir una comunidad.",
            'tipo_participante_id.required' => "El tipo de asistente es obligatorio.",
            'tipo_participante_id.min' => "Debes de elegir un tipo de asistente.",
            'activo.boolean' => 'El valor del campo activo debe ser No o Si.'
        ];
    }

}
