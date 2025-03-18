<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use App\Traits\CommonModelRequestTrait;
use App\Traits\ImageRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class MediaUploadRequest
 *
 * @category Request
 * @package  App\Http\Requests

 */
class MediaUploadRequest extends FormRequest
{

    use  ImageRequestTrait;


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
        $collection = collect(
            [
                'source'      => [
                    'required',
                    Rule::in(['UNKNOWN', 'CATEGORY', 'PRODUCT','BANNER']),
                ],

            ],
        );
        $merged = $collection->merge($this->getImageRequest(true));
        return $merged->toArray();

    }//end rules()


}//end class
