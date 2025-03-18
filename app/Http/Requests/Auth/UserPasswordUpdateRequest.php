<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterUserRequest
 *
 * @category Request
 * @package  App\Http\Requests\Auth
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserPasswordUpdateRequest extends FormRequest
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
            'password'             => [
                'required',
                'string',
                'min:8',
                'required_with:passwordConfirmation',
                'same:passwordConfirmation',
            ],
            'passwordConfirmation' => [
                'required',
                'min:8',
            ],
        ];

    }//end rules()


}//end class
