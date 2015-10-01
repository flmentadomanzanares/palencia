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
            "comunidad"    =>    "required|min:2|max:50",
            "responsable"    =>    "required|min:2|max:100",
            "direccion"    =>    "required|min:2|max:100",
            "cp"    =>    "required|size:5",
            "pais_id"    =>    "required",
            "provincia_id"    =>    "required",
            "localidad_id"    =>    "required",
            "email1"    =>    "email|max:50",
            "email2"    =>    "email|max:50",
            "web" => "min:6|max:50",
            "facebook" => "min:6|max:50",
            "telefono1"    =>    "min:6|max:13",
            "telefono2"    =>    "min:6|max:13",
            "observaciones" => "required|min:20",
            "registrada"    =>    "boolean",
            "activo"    =>    "boolean"

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
            'observaciones.min' => 'Longitud mínima de la comunidad :min caracteres.',
            'registrada.required' => 'El campo tutor es obligatorio!',
            'registrada.boolean' => 'El valor del campo tutor debe ser No o Si',
            'activo.required' => 'El campo tutor es obligatorio!',
            'activo.boolean' => 'El valor del campo tutor debe ser No o Si'
        ];
    }

}
