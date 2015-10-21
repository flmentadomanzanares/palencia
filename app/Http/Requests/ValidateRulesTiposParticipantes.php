<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposParticipantes extends Request {

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
            "tipo_participante"    =>    "required|min:2|max:50",
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'tipo_participante.required' => 'El tipo de participante es obligatorio!',
            'tipo_participante.min' => 'Longitud mínima del tipo de participante :min caracteres.',
            'tipo_participante.max' => 'Longitud máxima del tipo de participante :max caracteres.'
        ];
    }

}
