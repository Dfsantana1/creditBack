<?php
declare(strict_types=1);

namespace App\Http\Requests;


use Illuminate\Validation\Rule;
use App\Traits\UserRoleRequestTrait;
use App\Traits\CommonModelRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AddUserEntityRequest extends FormRequest
{
    use CommonModelRequestTrait, UserRoleRequestTrait;


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
     * @throws ValidationException
     */
    public function rules(): array
    {
        $modelRule = $this->getModelRequestRule();
        $roles     = $this->getUserRoleByRequest();
        return [
            'userId'           => [
                'required',
                'uuid',
                'exists:users,id',
            ],
            'role'             => [
                'required',
                'string',
                Rule::in($roles),
            ],
            $modelRule['name'] => $modelRule['rule'],
        ];

    }//end rules()


}//end class
