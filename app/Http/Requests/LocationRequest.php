<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class InvestorRequest
 *
 * @category Request
 * @package  App\Http\Requests
 * @author   Carolina Perez <caro.perez.baquero@outlook.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class LocationRequest extends FormRequest
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
            'userId'             => [
                'required',
                'uuid',
                'exists:users,id',
            ],
            'address_components' => ['required'],
            'formatted_address'  => ['required'],
            'geometry'           => ['required'],
        ];

    }//end rules()


}//end class
