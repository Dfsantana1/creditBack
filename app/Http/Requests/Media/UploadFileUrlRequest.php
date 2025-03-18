<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadFileUrlRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class UploadFileUrlRequest extends FormRequest
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
            'url' => [
                'required',
                'URL',
            ],
        ];

    }//end rules()


}//end class
