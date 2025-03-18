<?php
declare(strict_types=1);

namespace App\Http\Controllers\Saml2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Saml2\Saml2CreateTenantRequest;
use Illuminate\Http\JsonResponse;
use Slides\Saml2\Helpers\ConsoleHelper;
use Slides\Saml2\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;
use function response;

/**
 * Class Saml2TenantController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Saml2
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class Saml2TenantController extends Controller
{


    /**
     * @param  Saml2CreateTenantRequest $request
     * @return JsonResponse
     */
    public function __invoke(Saml2CreateTenantRequest $request): JsonResponse
    {
        $metadata = ConsoleHelper::stringToArray($request->input('metadata'));

        $tenant = new Tenant(
            [
                'uuid'            => $request->input('idpName'),
                'key'             => $request->input('idpKey'),
                'idp_entity_id'   => $request->input('idpEntityIdUrl'),
                'idp_login_url'   => $request->input('idpLoginUrl'),
                'idp_logout_url'  => $request->input('idpLogoutUrl'),
                'idp_x509_cert'   => $request->input('idpX509Cert'),
                'metadata'        => $metadata,
                'relay_state_url' => $request->input('relayStateUrl'),
                'name_id_format'  => $request->input('nameIdFormat', 'persistent'),
            ]
        );

        if (!$tenant->save()) {
            return response()
                ->json(['message' => 'Tenant cannot be saved.'])
                ->setStatusCode(Response::HTTP_OK);
        }

        return response()
            ->json(['message' => "The tenant #{$tenant->id} ({$tenant->uuid}) was successfully created."])
            ->setStatusCode(Response::HTTP_OK);

    }//end __invoke()


}//end class
