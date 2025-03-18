<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\LocationHelper;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Http\Resources\MediaResource;
use App\Models\Location\Location;
use App\Models\User\Relationship;
use App\Models\User;
use DateTimeZone;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class LocationController
 *
 * @extends  Controller
 * @category Controllers
 * @package  App\Http\Controllers

 */
class LocationController extends Controller
{


    /**
     * Create Location
     *
     * @param  LocationRequest $request
     * @return JsonResponse
     */
    protected function create(LocationRequest $request): JsonResponse
    {
        $addressComponents = $request->input('address_components', false);
        if (!$addressComponents) {
            return response()
                ->json(['message' => 'Cant Process'])
                ->setStatusCode(ResponseAlias::HTTP_NO_CONTENT);
        }

        $address = LocationHelper::mapLocation($addressComponents);
        $address['latitude']           = $request->input('geometry.location.lat', false);
        $address['longitude']          = $request->input('geometry.location.lng', false);
        $address['googleResponseJson'] = $request->all();
        $address['locationableId']     = $request->input('userId');
        $address['locationableType']   = User::class;
        $insert   = Location::query()->create($address);
        $location = Location::find($insert->id);
        return response()
            ->json(LocationResource::make($location))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end create()


}//end class
