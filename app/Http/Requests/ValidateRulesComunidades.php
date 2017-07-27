<?php namespace Palencia\Http\Requests;

class ValidateRulesComunidades extends Request
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
            "comunidad" => "required|min:1",
            "tipo_secretariado_id" => "required|numeric|min:1",
            "direccion" => "max:100",
            "pais" => "required|numeric|min:1",
            "provincias" => "required|numeric|min:1",
            "localidades" => "required|numeric|min:1",
            "email_solicitud" => "email|max:60",
            "email_envio" => "email|max:60",
            "web" => "max:50",
            "facebook" => "max:50",
            "telefono1" => "max:13",
            "telefono2" => "max:13",
            "tipo_comunicacion_preferida_id" => "required|numeric|min:1",
            "esPropia" => "boolean",
            "esColaborador" => "boolean",
            "activo" => "boolean"

        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunidad.required' => 'El nombre de la comunidad es obligatorio.',
            'comunidad.min' => 'Longitud m&iacute;nima nombre de la comunidad :min caracteres.',
            'responsable.required' => 'El responsable es obligatorio.',
            'responsable.min' => 'Longitud m&iacute;nima del responsable :min caracteres.',
            'responsable.max' => 'Longitud m&aacute;xima del responsable :max caracteres.',
            //'cp.required' => 'El codigo postal es obligatorio.',
            //'cp.size' => 'El codigo postal debe tener :size caracteres.',
            'tipo_secretariado_id.required' => 'El secretariado es obligatorio.',
            'tipo_secretariado_id.min' => 'Elige un  secretariado.',
            'pais.required' => 'El pa&iacute;s es obligatorio.',
            'pais.min' => 'Elige un pa&iacute;s.',
            'provincias.required' => 'La provincia es obligatoria.',
            'provincias.min' => 'Elige una provincia.',
            'localidades.required' => 'La localidad es obligatoria.',
            'localidades.min' => 'Elige una localidad.',
            'email_solicitud.email' => 'La direccion de e-mail1 no es valida.',
            'email_solicitud.max' => 'Longitud m&aacute;xima del e-mail1 :max caracteres.',
            'email_envio.email' => 'La direccion de e-mail2 no es valida.',
            'email_envio.max' => 'Longitud m&aacute;xima del e-mail2 :max caracteres.',
            'web.min' => 'Longitud m&iacute;nima de la web :min caracteres.',
            'web.max' => 'Longitud m&aacute;xima de la web :max caracteres.',
            'facebook.min' => 'Longitud m&iacute;nima de la web :min caracteres.',
            'facebook.max' => 'Longitud m&aacute;xima de la web :max caracteres.',
            'telefono1.min' => 'Longitud m&iacute;nima del tel&eacute;fono1 :min caracteres.',
            'telefono1.max' => 'Longitud m&aacute;xima del tel&eacute;fono1 :max caracteres.',
            'telefono2.min' => 'Longitud m&iacute;nima del tel&eacute;fono2 :min caracteres.',
            'telefono2.max' => 'Longitud m&aacute;xima del tel&eacute;fono2 :max caracteres.',
            'observaciones.min' => 'Longitud m&iacute;nima de la comunidad :min caracteres.',
            'tipo_comunicacion_preferida_id.required' => 'La comunicaci&oacute;n preferida es obligatoria.',
            'tipo_comunicacion_preferida_id.min' => 'Elige una comunicaci&oacute;n preferida.',
            'activo.required' => 'El campo activo es obligatorio!',
            'activo.boolean' => 'El valor del campo activo debe ser No o Si',
            'esPropia.boolean' => 'El valor del campo es Propia debe ser No o Si',
            'esColaborador.boolean' => 'El valor del campo es Colaborador debe ser No o Si'
        ];
    }

}
