<?php namespace Palencia\Http\Requests;

class ValidateRulesEstadosSolicitudes extends Request {

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
            "estado_solicitud"    =>    "required|min:2|max:50",
        ];
    }
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'estado_solicitud.required' => 'El estado de solicitud es obligatorio!',
            'estado_solicitud.min' => 'Longitud mínima del estado de solicitud :min caracteres.',
            'estado_solicitud.max' => 'Longitud máxima del estado de solicitud :max caracteres.'
        ];
    }

}
