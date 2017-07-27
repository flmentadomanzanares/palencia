<?php namespace Palencia\Http\Requests;

class ValidateRulesLocalidades extends Request
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
            "pais" => "required",
            "provincias" => "required",
            "localidad" => "required|min:2|max:50",
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'localidad.required' => 'La localidad es obligatoria.',
            'localidad.min' => 'Longitud m&iacute;nima de la localidad :min caracteres.',
            'localidad.max' => 'Longitud m&aacute;xima de la localidad :max caracteres.',
            "pais.required" => 'El pa&iacute;s es obligatorio.',
            "provincias.required" => 'La provincia es obligatoria.',
        ];
    }

}
