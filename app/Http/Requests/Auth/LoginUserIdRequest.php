<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class LoginUserIdRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class LoginUserIdRequest extends FormRequest
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
        ];

    }//end rules()


}//end class
