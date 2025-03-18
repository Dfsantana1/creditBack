<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PasswordTokenCheckRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class PasswordTokenCheckRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'email',
                'required',
                'exists:users,email',
            ],
            'token' => [
                'string',
                'required',
                'exists:passwordResets,token',
            ],
        ];

    }//end rules()


}//end class
