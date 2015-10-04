<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposSecretariados extends Request {

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
            "secretariado"    =>    "required|min:2|max:50",
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'secretariado.required' => 'El tipo de secretariado es obligatorio!',
            'secretariado.min' => 'Longitud mínima del tipo de secretariado :min caracteres.',
            'secretariado.max' => 'Longitud máxima del tipo de secretariado :max caracteres.'
        ];
    }

}
