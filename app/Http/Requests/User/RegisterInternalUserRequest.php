<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Enums\User\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;


/**
 * Class RegisterInternalUserRequest
 *
 * @category Request
 * @package  App\Http\Requests
 * @author   Diego Santana <dsantanafernandez@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class RegisterInternalUserRequest extends FormRequest
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
            'firstName'        => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'lastName'         => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'email'            => [
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'nullable',
            ],
            'password'         => [
                'string',
                'min:8',
            ],
            'role'             => [
                'required',
                'exists:roles,name',
            ],
            "phoneNumber"      => [
                'numeric',
                'digits:10',
            ],
            'crmId'            => [
                'string',
                'nullable',
            ],
        ];

    }//end rules()


}//end class
