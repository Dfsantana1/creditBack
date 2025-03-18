<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserUpdateRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class UserUpdateRoleRequest extends FormRequest
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
            'userId' => [
                'required',
                'uuid',
                'exists:users,id',
            ],
            'role'   => [
                'required',
                'exists:roles,name',
                Rule::notIn(['ADMIN']),
            ],
        ];

    }//end rules()


}//end class
