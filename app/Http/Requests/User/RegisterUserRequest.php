<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * Class RegisterUserRequest
 *
 * @category Request
 * @package  App\Http\Requests
 * @author   Diego Santana <dsantanafernandez@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class RegisterUserRequest extends FormRequest
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
            'firstName'            => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'lastName'             => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email'                => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
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
            ]
        ];

    }//end rules()


}//end class
