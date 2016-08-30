<?php namespace Palencia\Http\Requests;

class ValidateRulesPaises extends Request
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
            "pais" => "required|min:2|max:50",
        ];
    }

    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'pais.required' => 'El pa&iacute;s es obligatorio!',
            'pais.min' => 'Longitud m&iacute;nima del pa&iacute;s :min caracteres.',
            'pais.max' => 'Longitud m&aacute;xima del pa&iacute;s :max caracteres.'
        ];
    }

}
