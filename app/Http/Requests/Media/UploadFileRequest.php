<?php
declare(strict_types=1);

namespace App\Http\Requests\Media;

use App\Traits\CommonModelRequestTrait;
use App\Traits\ImageRequestTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
class UploadFileRequest extends FormRequest
{

    use CommonModelRequestTrait, ImageRequestTrait;


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
     * @throws ValidationException
     */
    public function rules(): array
    {
        $modelRule  = $this->getModelRequestRule();
        $collection = collect(
            [
                'reference'        => [
                    'required',
                    'string'
                ],
                $modelRule['name'] => $modelRule['rule'],
            ]
        );
        $merged     = $collection->merge($this->getImageRequest());
        return $merged->toArray();

    }//end rules()


}//end class
