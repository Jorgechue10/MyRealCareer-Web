<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Autorizar sólo a los usuarios con rol de "administrador"
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->esAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|max:255',
            'contenido' => 'required|max:6100',
            'foto' => 'mimes:jpeg,jpg,png,gif,bmp,tiff|max:2048'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'max' => 'El campo :attribute no puede tener más de :max dígitos.',
            'mimes' => 'Sólo están permitidos los formatos: jpeg, png, gif, bmp, tiff.'
        ];
    }
}