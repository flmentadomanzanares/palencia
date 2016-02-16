<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposComunicacionesPreferidas extends Request
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
            "comunicacion_preferida" => "required|min:2|max:50",
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunicacion_preferida.required' => 'El tipo de comunicación preferida es obligatoria!',
            'comunicacion_preferida.min' => 'Longitud mínima del tipo de comunicación preferida :min caracteres.',
            'comunicacion_preferida.max' => 'Longitud máxima del tipo de comunicación preferida :max caracteres.'
        ];
    }

}
