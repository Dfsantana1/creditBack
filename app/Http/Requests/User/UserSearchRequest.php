<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserSearchRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class UserSearchRequest extends FormRequest
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
            'search' => [
                'required',
                'string',
                'max:255',
            ],
        ];

    }//end rules()


}//end class
