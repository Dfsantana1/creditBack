<?php
declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PasswordUpdateRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class PasswordUpdateRequest extends FormRequest
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
            'email'                => [
                'email',
                'required',
                'exists:users,email',
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
            ],
        ];

    }//end rules()


}//end class
