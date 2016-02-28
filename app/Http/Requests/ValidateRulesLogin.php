<?php namespace Palencia\Http\Requests;

class ValidateRulesLogin extends Request
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
            "email" => "required|email",
            "password" => "required"
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'email.required' => 'El email es abligatorio.',
            'email.email' => 'El email no tiene el formato adecauado.',
            'password.required' => 'La password es obligatoria.'
        ];
    }

}
