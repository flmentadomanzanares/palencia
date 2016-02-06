<?php namespace Palencia\Http\Requests;

class ValidateRulesUsers extends Request {

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
            "fullname"    =>    "required|min:6|max:60",
            'name'        =>    "required|min:2|max:20",
            'foto'        =>    "image|mimes:jpeg,bmp,png",
            'password'    =>    'min:6|max:60|confirmed'
		];
	}
    public function messages()
    {
        return [//Asignamos un texto por cada regla sobre cada campo
            'fullname.required' => 'El Nombre Completo es obligatorio.',
            'fullname.min' => 'Longitud mínima del Nombre Completo :min caracteres.',
            'fullname.max' => 'Longitud máxima del Nombre Completo :max caracteres.',
            'name.required' => 'El Nombre de Usuario es obligatorio.',
            'name.min' => 'Longitud mínima del Nombre de Usuario :min caracteres.',
            'name.max' => 'Longitud máxima del Nombre de Usuario :max caracteres.',
            'foto.mimes' => 'Formato de imagen no válido. usa formato jpeg, png y/o jpg.',
            'password.min' => 'Longitud mínima del Password :min caracteres.',
            'password.max' => 'Longitud máxima del Password :max caracteres.',
				'password.confirmed' => 'Password no coincidente.',
        ];
    }

}
