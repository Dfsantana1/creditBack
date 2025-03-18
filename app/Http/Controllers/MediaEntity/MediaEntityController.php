<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Helpers\MediaEntityHelper;
use App\Http\Controllers\Controller;
use App\Models\Media\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

/**
 * Class MediaEntityController
 *
 * @category Controller
 * @package  App\Http\Controllers\MediaEntity
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityController extends Controller
{


    /**
     * Get media entities by media id
     *
     * @param  Media $media
     * @return JsonResponse
     */
    public function getMediaEntitiesByMediaId(Media $media): JsonResponse
    {
        /**
         * @var Collection $mediaEntities
         */
        $mediaEntities = $media->mediaEntities;

        if ($mediaEntities->isEmpty()) {
            return response()
                ->json(['message' => 'No media entities found'])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $mediaEntities->transform(
            function ($mediaEntity) {
                $mediaEntity->entity = MediaEntityHelper::getResourceFromEntity($mediaEntity->entityType::find($mediaEntity->entityId));
                return $mediaEntity;
            }
        );

        return response()->json($mediaEntities);

    }//end getMediaEntitiesByMediaId()


}//end class
