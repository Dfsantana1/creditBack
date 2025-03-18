<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * Class UserUpdateRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class UserUpdateRequest extends FormRequest
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
                'max:255',
            ],
            'lastName'         => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'email'            => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(last(request()->segments())),
            ],
            'crmId'            => [
                'string',
                'nullable',
            ],
            'careType'         => [
                'string',
                'nullable',
                'exists:careTypes,id',
            ],
        ];

    }//end rules()


}//end class
