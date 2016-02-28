<?php namespace Palencia\Http\Requests;

class ValidateRulesSemanaCursilloComunidades extends Request
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
            "cursillo_id" => "required",
            "comunidad_id" => "required",
            "calendario_id" => "required",
            "activo" => "boolean"

        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'cursillo_id.required' => "Debes de elegir un cursillo.",
            'comunidad_id.required' => "Debes de elegir una comunidad.",
            'calendario_id.required' => "Debes de elegir una entrada del calendario.",
            'activo.boolean' => 'El valor del campo activo debe ser No o Si'
        ];
    }

}
