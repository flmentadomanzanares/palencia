<?php namespace Palencia\Http\Requests;

class ValidateRulesProvincias extends Request
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
            "pais" => "required|numeric|min:1",
            "provincia" => "required|min:2|max:50",

        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'provincia.required' => 'La provincia es obligatoria!',
            'provincia.min' => 'Longitud m&iacute;nima de la provincia :min caracteres.',
            'provincia.max' => 'Longitud m&aacute;xima de la provincia :max caracteres.',
            'pais.min' => 'Debes de seleccionar un pa&iacute;s.',


        ];
    }

}
