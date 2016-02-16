<?php namespace Palencia\Http\Requests;

class ValidateRulesRoles extends Request
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
            "rol" => "required|min:2|max:50",
            "peso" => "required|integer"
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'rol.required' => 'El rol es obligatorio!',
            'rol.min' => 'Longitud mínima del rol :min caracteres.',
            'rol.max' => 'Longitud máxima del rol :max caracteres.',
            'peso.required' => 'El peso es obligatorio!',
            'rol.integer' => 'El rol debe ser un numero entero.'
        ];
    }

}
