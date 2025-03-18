<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class LoginRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class LoginRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;

    }//end authorize()


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'    => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ];

    }//end rules()


}//end class
