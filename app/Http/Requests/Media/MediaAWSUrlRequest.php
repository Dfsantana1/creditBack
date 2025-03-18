<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use App\Enums\User\UserRoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MediaAWSUrlRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class MediaAWSUrlRequest extends FormRequest
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
            'url'           => [
                'required',
                'URL',
        //                function ($attribute, $value, $fail) {
        //                    if (!ImageHelper::fileExists($value)) {
        //                        $fail('File no exist');
        //                    }
        //                },
            ],
            'interviewerId' => [
                'nullable',
                'uuid',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if (request()->has('interviewerId')) {
                        $interviewerUser = User::query()
                            ->join('userRoles', 'userRoles.userId', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'userRoles.roleId')
                            ->where('users.id', request()->input('interviewerId'))
                            ->first();
                        if (empty($interviewerUser)) {
                            $fail('The '.$attribute.' is invalid');
                        }
                    }
                },
            ],
            'userId'        => [
                'required',
                'uuid',
                'exists:users,id',
            ],
        ];

    }//end rules()


}//end class
