<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposComunidades extends Request {

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
            "comunidad"    =>    "required|min:2|max:50",
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunidad.required' => 'El tipo de comunidad es obligatorio!',
            'comunidad.min' => 'Longitud mínima del tipo de comunidad :min caracteres.',
            'comunidad.max' => 'Longitud máxima del tipo de comunidad :max caracteres.'
        ];
    }

}
