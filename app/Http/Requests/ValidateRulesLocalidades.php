<?php namespace Palencia\Http\Requests;

use Palencia\Http\Requests\Request;

class ValidateRulesLocalidades extends Request {

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
            "pais" => "required",
            "provincia" => "required",
            "localidad"    =>    "required|min:2|max:50",
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'localidad.required' => 'La localidad es obligatoria.',
            'localidad.min' => 'Longitud mínima de la localidad :min caracteres.',
            'localidad.max' => 'Longitud máxima de la localidad :max caracteres.',
            "pais.required" => 'El país es obligatorio.',
            "provincia.required" => 'La provincia es obligatoria.',
        ];
    }

}
