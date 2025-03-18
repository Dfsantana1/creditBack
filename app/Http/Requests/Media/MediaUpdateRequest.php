<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MediaUpdateRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class MediaUpdateRequest extends FormRequest
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
            'name'                  => [
                'required',
                'string',
                'max:100',
            ],
			'documentId'                  => [
                'required',
                'string',
            ],
            'description'           => [
                'string',
                'max:255',
            ],
            'corporationFileTypeId' => [
                'exists:corporationFileTypes,id',
                'uuid',
            ],
            'dueAt'                 => ['date_format:Y-m-d'],
        ];

    }//end rules()


}//end class
