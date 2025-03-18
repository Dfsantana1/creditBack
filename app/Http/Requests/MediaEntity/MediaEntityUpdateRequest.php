<?php

namespace App\Http\Requests\MediaEntity;

use App\Helpers\MediaEntityHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class MediaEntityUpdateRequest
 *
 * @category Request
 * @package  App\Http\Requests\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityUpdateRequest extends FormRequest
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
            'mediaId'    => [
                'uuid',
                'exists:media,id',
            ],
            'entityId'   => [
                'required',
                'uuid',
            ],
            'entityType' => [
                'required',
                'string',
                Rule::in(MediaEntityHelper::getMediaEntityTypes()),
            ],
        ];

    }//end rules()


}//end class
