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
            "comunidad"=>"required|min:4",
            "tipo_secretariado_id" => "required|numeric|min:1",
            "direccion" => "required|min:2|max:100",
            "pais_id" => "required|numeric|min:1",
            "provincia_id" => "required|numeric|min:1",
            "localidad_id" => "required|numeric|min:1",
            "email1" => "email|max:50",
            "email2" => "email|max:50",
            "web" => "max:50",
            "facebook" => "max:50",
            "telefono1" => "max:13",
            "telefono2" => "max:13",
            "tipo_comunicacion_preferida_id" => "required|numeric|min:1",
            "esPropia"=>"boolean",
            "esColaborador"=>"boolean",
            "activo" => "boolean"

        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunidad.required' => 'El nombre de la comunidad es obligatorio.',
            'comunidad.min' => 'Longitud mínima nombre de la comunidad :min caracteres.',
            'responsable.required' => 'El responsable es obligatorio.',
            'responsable.min' => 'Longitud mínima del responsable :min caracteres.',
            'responsable.max' => 'Longitud máxima del responsable :max caracteres.',
            'cp.required' => 'El codigo postal es obligatorio.',
            'cp.size' => 'El codigo postal debe tener :size caracteres.',
            'tipo_secretariado_id.required' => 'El secretariado es obligatorio.',
            'tipo_secretariado_id.min' => 'Elige un  secretariado.',
            'pais_id.required' => 'El pais es obligatorio.',
            'pais_id.min' => 'Elige un país.',
            'provincia_id.required' => 'La provincia es obligatoria.',
            'provincia_id.min' => 'Elige una provincia.',
            'localidad_id.required' => 'La localidad es obligatoria.',
            'localidad_id.min' => 'Elige una localidad.',
            'email1.email' => 'La direccion de e-mail1 no es valida.',
            'email1.max' => 'Longitud máxima del e-mail1 :max caracteres.',
            'email2.email' => 'La direccion de e-mail2 no es valida.',
            'email2.max' => 'Longitud máxima del e-mail2 :max caracteres.',
            'web.min' => 'Longitud mínima de la web :min caracteres.',
            'web.max' => 'Longitud máxima de la web :max caracteres.',
            'facebook.min' => 'Longitud mínima de la web :min caracteres.',
            'facebook.max' => 'Longitud máxima de la web :max caracteres.',
            'telefono1.min' => 'Longitud mínima del teléfono1 :min caracteres.',
            'telefono1.max' => 'Longitud máxima del teléfono1 :max caracteres.',
            'telefono2.min' => 'Longitud mínima del teléfono2 :min caracteres.',
            'telefono2.max' => 'Longitud máxima del teléfono2 :max caracteres.',
            'observaciones.min' => 'Longitud mínima de la comunidad :min caracteres.',
            'tipo_comunicacion_preferida_id.required' => 'La comunicación preferida es obligatoria.',
            'tipo_comunicacion_preferida_id.min' => 'Elige una comunicación preferida.',
            'activo.required' => 'El campo activo es obligatorio!',
            'activo.boolean' => 'El valor del campo activo debe ser No o Si',
            'esPropia.boolean' => 'El valor del campo es Propia debe ser No o Si',
            'esColaborador.boolean' => 'El valor del campo es Colaborador debe ser No o Si'
        ];
    }

}
