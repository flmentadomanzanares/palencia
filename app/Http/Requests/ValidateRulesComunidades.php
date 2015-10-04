<?php namespace Palencia\Http\Requests;

use Palencia\Http\Requests\Request;

class ValidateRulesComunidades extends Request {

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
            "comunidad"    =>                   "required|min:2|max:50",
            "num_comunidad" =>                  "numeric",
            "tipo_comunidad_id" =>              "required|numeric",
            "responsable"    =>                 "required|min:2|max:100",
            "direccion"    =>                   "required|min:2|max:100",
            "cp"    =>                          "required|size:5",
            "pais_id"    =>                     "required|numeric",
            "provincia_id"    =>                "required|numeric",
            "localidad_id"    =>                "required|numeric",
            "email1"    =>                      "email|max:50",
            "email2"    =>                      "email|max:50",
            "web" =>                            "max:50",
            "facebook" =>                       "max:50",
            "telefono1"    =>                   "max:13",
            "telefono2"    =>                   "max:13",
            "tipo_comunicacion_preferida_id" => "required|numeric",
            "observaciones" =>                  "required|min:5",
            "activo"    =>                      "boolean"

        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunidad.required' => 'La comunidad es obligatoria.',
            'comunidad.min' => 'Longitud mínima de la comunidad :min caracteres.',
            'comunidad.max' => 'Longitud máxima de la comunidad :max caracteres.',
            'responsable.required' => 'El responsable es obligatorio.',
            'responsable.min' => 'Longitud mínima del responsable :min caracteres.',
            'responsable.max' => 'Longitud máxima del responsable :max caracteres.',
            'cp.required' => 'El codigo postal es obligatorio.',
            'cp.size' => 'El codigo postal debe tener :size caracteres.',
            'tipo_comunidad_id.required' => 'El tipo de comunicdad es obligatorio.',
            'pais_id.required' => 'El pais es obligatorio.',
            'provincia_id.required' => 'La provincia es obligatoria.',
            'localidad_id.required' => 'La localidad es obligatoria.',
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
            'observaciones.required' => 'La comunidad es obligatoria.',
            'tipo_comunicacion_preferida_id.required' => 'La comunicación preferida es obligatoria.',
            'observaciones.min' => 'Longitud mínima de la comunidad :min caracteres.',
            'activo.required' => 'El campo tutor es obligatorio!',
            'activo.boolean' => 'El valor del campo tutor debe ser No o Si'
        ];
    }

}
