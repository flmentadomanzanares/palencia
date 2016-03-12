<?php namespace Palencia\Http\Requests;

class ValidateRulesSolicitudesEnviadas extends Request
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
            "aceptada" => "boolean",
            "activo" => "boolean"
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunidad_id.required' => 'La comunidad es obligatoria.',
            'aceptada.required' => 'El campo aceptada es obligatorio!',
            'aceptada.boolean' => 'El valor del campo aceptada debe ser No o Si',
            'activo.required' => 'El campo activo es obligatorio!',
            'activo.boolean' => 'El valor del campo activo debe ser No o Si'
        ];
    }

}
