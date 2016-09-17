<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposSecretariados extends Request
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
            "tipo_secretariado" => "required|min:2|max:50",
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'tipo_secretariado.required' => 'El tipo de secretariado es obligatorio!',
            'tipo_secretariado.min' => 'Longitud m&iacute;nima del tipo de secretariado :min caracteres.',
            'tipo_secretariado.max' => 'Longitud m&aacute;xima del tipo de secretariado :max caracteres.'
        ];
    }

}
