<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Media\MediaUploadRequest;
use App\Http\Resources\MediaResource;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class MediaController
 *
 * @extends  Controller
 * @category Controllers
 * @package  App\Http\Controllers

 */
class MediaController extends Controller
{
    use UploadTrait;


    /**
     * @param  MediaUploadRequest $request
     * @return JsonResponse
     */
    protected function uploadFile(MediaUploadRequest $request): JsonResponse
    {
        $reference = $request->input('reference', 'UNKNOWN');

        $object = null;
		if ($request->has('userId')) {
            $object = User::find($request->input('userId'));
        }

        $medias = $this->storeUploadedFile([$request->file('file')], $object, $reference);
        return response()
            ->json(MediaResource::collection($medias))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end uploadFile()


}//end class
