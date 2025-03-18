<?php
declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Search\SearchResource;
use App\Http\Requests\SearchControllerRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class SearchController
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SearchController extends Controller
{


    /**
     * Get users, stories and people from query
     *
     * @param  SearchControllerRequest $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $q = $request->input('query');
        $searchCommunities = true;
        $limit = 16;
        $data  = collect([]);

        $residentsBuilder = User::query()
            ->select(['users.id', 'users.createdAt'])
            ->join('userRoles', 'userRoles.userId', 'users.id')
            ->join('roles', 'roles.id', 'userRoles.roleId')
            ->join('userProfiles', 'userProfiles.userId', 'users.id')
            ->whereNull('userRoles.deletedAt')
            ->whereNull('userProfiles.archivedAt');

        $residentsBuilder->whereHas(
            'profile',
            function (Builder $query) use ($q) {
                $query->where('userProfiles.firstName', 'like', "%$q%")
                    ->orWhere('userProfiles.lastName', 'like', "%$q%")
                    ->orWhere('userProfiles.code', 'like', "%$q%")
                    ->orWhere('userProfiles.preferredName', 'like', "%$q%");
            }
        )->limit($limit);

        $data->put('residents', $residentsBuilder->get());

        return response()
            ->json(SearchResource::make($data))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end search()


}//end class
