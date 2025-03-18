<?php

namespace App\Http\Requests;

use App\Enums\Corporation\CorporationImageTypeEnum;
use App\Enums\RecordingTypeEnum;
use App\Enums\StoryStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

/**
 * Class PaginationRequest
 *
 * @category Request
 * @property int $limit
 * @property int $offset
 * @property int $page
 * @property string $order_by
 * @package  App\Http\Requests

 */
class PaginationRequest extends FormRequest
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
        $collection = collect(
            [
                'limit'     => ['integer'],
                'offset'    => ['integer'],
                'page'      => [
                    'required',
                    'integer',
                ],
                'order_by'  => ['string'],
                'direction' => ['in:ASC,DESC'],
                'q'         => ['min:3'],
                'includes'  => ['array'],
            ]
        );


        if (request()->has('filters')) {
            $collection = $collection->merge(
                [
                    'filters.roles'                  => ['array'],
                    'filters.roles.*'                => ['exists:roles,name'],
                    'filters.sources'                => ['array'],
                    'filters.sources.*'              => [Rule::in(['UNKNOWN'])],
                    'filters.extensions'             => ['array'],
                ]
            );
        }//end if

        if (in_array('media', request()->segments())) {
            $collection = $collection->merge(
                [
                    'orderBy' => ['in:name,createdAt'],
                ]
            );
        }
        return $collection->toArray();

    }//end rules()


}//end class
