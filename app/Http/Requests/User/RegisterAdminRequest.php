<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


/**
 * Class RegisterInternalUserRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class RegisterAdminRequest extends FormRequest
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
            'firstName' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'lastName'  => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email'     => [
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password'  => [
                'string',
                'min:8',
            ],
            'role'      => [
                'required',
                'exists:roles,name',
            ],

        ];

    }//end rules()


}//end class
