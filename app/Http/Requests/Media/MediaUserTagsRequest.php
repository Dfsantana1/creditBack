<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MediaUserTagsRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class MediaUserTagsRequest extends FormRequest
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
            'mediaId' => [
                'required',
                'uuid',
                'exists:media,id',
            ],
            'userId'  => [
                'required',
                'uuid',
                'exists:users,id',
            ],
            'page'    => ['integer'],
            'note'    => [
                'string',
                'max:255',
            ],
        ];

    }//end rules()


}//end class
