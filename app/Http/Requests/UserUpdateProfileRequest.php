<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateProfileRequest
 *
 * @category Request
 * @package  App\Http\Requests
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserUpdateProfileRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

    }//end authorize()


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'userId'  => [
                'uuid',
                'required',
                'exists:userProfiles,userId',
            ],
            'mediaId' => [
                'uuid',
                'required',
                'exists:media,id',
            ],
        ];

    }//end rules()


}//end class
