<?php namespace Palencia\Http\Requests;

class ValidateRulesTiposComunicacionesPreferidas extends Request
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
            "comunicacion_preferida" => "required|min:2|max:50",
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'comunicacion_preferida.required' => 'El tipo de comunicaci&oacute;n preferida es obligatoria!',
            'comunicacion_preferida.min' => 'Longitud m&iacute;nima del tipo de comunicaci&oacute;n preferida :min caracteres.',
            'comunicacion_preferida.max' => 'Longitud m&aacute;xima del tipo de comunicaci&oacute;n preferida :max caracteres.'
        ];
    }

}
