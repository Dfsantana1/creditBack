<?php
declare(strict_types=1);

namespace App\Http\Requests\Saml2;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SamlCreateTenantRequest
 *
 * @category Request
 * @package  App\Http\Requests\Saml2
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class Saml2CreateTenantRequest extends FormRequest
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
        return [
            'idpName'        => [
                'string',
                'required',
                'unique:saml2_tenants,uuid',
                'max:200',
            ],
            'idpKey'         => [
                'string',
                'required',
                'unique:saml2_tenants,key',
                'max:200',
            ],
            'idpEntityIdUrl' => [
                'string',
                'required',
            ],
            'idpLoginUrl'    => [
                'string',
                'required',
            ],
            'idpLogoutUrl'   => [
                'string',
                'required',
            ],
            'idpX509Cert'    => [
                'string',
                'required',
            ],
        ];

    }//end rules()


}//end class
