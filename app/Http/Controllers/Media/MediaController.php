<?php
declare(strict_types=1);

namespace App\Http\Controllers\Media;

use Exception;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Helpers\ImageHelper;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Models\Media\MediaUserTags;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\MediaResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Media\Media as MediaModel;
use PhpOffice\PhpPresentation\Writer\PDF;
use App\Http\Resources\MediaCompleteResource;
use PhpOffice\PhpPresentation\PhpPresentation;
use App\Http\Requests\Media\MediaAWSUrlRequest;
use App\Http\Requests\Media\MediaUploadRequest;
use App\Http\Requests\Media\MediaUserTagsRequest;
use App\Http\Requests\Media\UploadFileUrlRequest;
use PhpOffice\PhpPresentation\IOFactory as PPTIOFactory;
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
    use ScopesTrait, UploadTrait;


    /**
     * @param  MediaUploadRequest $request
     * @return JsonResponse
     */
    protected function uploadFile(MediaUploadRequest $request): JsonResponse
    {
        $object = null;
		$requestFile = $request->file('file');

		if($request->input('productId')){
			$object = Product::find($request->input('productId'));
		} else if ($request->input('categoryId')) {
            $object = Category::find($request->input('categoryId'));
        } else if ($request->input('tagId')) {
            $object = Tag::find($request->input('tagId'));
        } else if ($request->input('productColorId')) {
            $object = ProductColor::find($request->input('productColorId'));
        }

		$medias = $this->storeUploadedFile([$requestFile], $object);

		$extension = $requestFile->extension();
		$wordExtensions = ['docx', 'dotx', 'dot', 'doc'];
		$pptTxtExtensions = ['ppt', 'pptx', 'pps', 'ppsx', 'pot', 'potx', 'txt'];
		$documentName = $requestFile->getClientOriginalName();
		$filenameWithoutExt = pathinfo($documentName, PATHINFO_FILENAME);
		$outputFilePath = public_path('tmp/') . $filenameWithoutExt . '.pdf';
		if (in_array($extension, $wordExtensions)) {
			$tempFilePath = $requestFile->getRealPath();
			$phpWord = IOFactory::load($tempFilePath, 'Word2007');
			$xmlWriter = IOFactory::createWriter($phpWord, 'HTML');
			ob_start();
			$xmlWriter->save('php://output');
			$html = ob_get_contents();
			ob_end_clean();
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$output = $dompdf->output();
			$result = file_put_contents($outputFilePath, $output);
			$file   = new UploadedFile($outputFilePath, basename($filenameWithoutExt . '.pdf'), mime_content_type($outputFilePath));
			$this->storeUploadedFile([$file], $object, $medias[0]);
		} else if(in_array($extension, $pptTxtExtensions)) {
			//Remove Special Characters
			$filenameWithoutExtAux = preg_replace('/[^A-Za-z0-9\-. ]/', '', str_replace(" ", "", strtolower($filenameWithoutExt)));
			$documentNameAux = preg_replace('/[^A-Za-z0-9\-. ]/', '', str_replace(" ", "", strtolower($documentName)));

			$outputFilePath = public_path('tmp/') . $filenameWithoutExtAux . '.pdf';
			Storage::disk('public')->putFileAs('tmp', $requestFile, $documentNameAux, 'public');
			$inputPath = public_path('tmp/') . $documentNameAux;
			$command = 'soffice --headless --convert-to pdf ' . $inputPath . ' -outdir tmp';
			$output  = shell_exec($command. ' 2>&1');
			$file   = new UploadedFile($outputFilePath, basename($filenameWithoutExtAux . '.pdf'), mime_content_type($outputFilePath));
			$this->storeUploadedFile([$file], $object, $medias[0]);
		}
        return response()
            ->json(MediaCompleteResource::collection($medias))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end uploadFile()


    /**
     * Create Media File from External URL
     *
     * @param  UploadFileUrlRequest $request
     * @return JsonResponse
     */
    public function uploadFileFromUrl(UploadFileUrlRequest $request): JsonResponse
    {
        $object = null;
        // Check if Exist
        if (!ImageHelper::fileExists($request->input('url'))) {
            return response()
                ->json(['message' => 'File no exist'])
                ->setStatusCode(ResponseAlias::HTTP_BAD_REQUEST);
        }
        try {
            $url      = $request->input('url');
            $ext      = pathinfo($url, PATHINFO_EXTENSION);
            $filename = uniqid().'.'.$ext;
            $newFile  = public_path('tmp/').$filename;
            if (copy($url, $newFile)) {
                $file   = new UploadedFile($newFile, basename($url), mime_content_type($newFile));
                $medias = $this->storeUploadedFile([$file], $object);
                if (!$medias) {
                    return response()
                        ->json(['message' => 'error : not valid file'])
                        ->setStatusCode(ResponseAlias::HTTP_BAD_REQUEST);
                }

                return response()
                    ->json(MediaResource::collection($medias))
                    ->setStatusCode(ResponseAlias::HTTP_OK);
            }
        } catch (\Throwable $e) {
            return response()
                ->json(['message' => 'error : '.$e->getMessage()])
                ->setStatusCode(ResponseAlias::HTTP_BAD_REQUEST);
        }//end try

    }//end uploadFileFromUrl()


    /**
     * Create Media Given URL (Mobile Uploads)
     *
     * @param  MediaAWSUrlRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    protected function createMediaForAWSUrl(MediaAWSUrlRequest $request): JsonResponse
    {
        $media = MediaModel::processUploadedAWSUrl($request);

        return response()
            ->json(MediaCompleteResource::make($media))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end createMediaForAWSUrl()


    /**
     * Create Media User Tag
     *
     * @param  MediaUserTagsRequest $request
     * @return JsonResponse
     */
    public function addUserTag(MediaUserTagsRequest $request): JsonResponse
    {
        MediaUserTags::query()->updateOrCreate(
            [
                'userId'  => $request->input('userId'),
                'mediaId' => $request->input('mediaId'),
                'page'    => $request->input('page'),
                'note'    => $request->input('note'),
            ]
        );
        return response()
            ->json(['message' => 'User Media Tag Added'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end addUserTag()


    /**
     * Create Media User Tag
     *
     * @param  MediaUserTags $mediaUserTag
     * @return JsonResponse
     */
    public function deleteUserTag(MediaUserTags $mediaUserTag): JsonResponse
    {
        $mediaUserTag->delete();
        return response()
            ->json(['message' => 'User Media Tag Deleted'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end deleteUserTag()


    /**
     * Delete media resource
     *
     * @param  Media $media
     * @return JsonResponse
     */
    public function delete(MediaModel $media): JsonResponse
    {
        $media->delete();
        $this->deleteUploadedFile($media);

        foreach ($media->children as $child) {
            $child->delete();
            $this->deleteUploadedFile($child);
        }

        return response()
            ->json(['message' => 'Media deleted successfully!'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end delete()


    /**
     * @param  UploadFileUrlRequest $request
     * @return JsonResponse
     */
    protected function encodeImage(UploadFileUrlRequest $request): JsonResponse
    {
        $type   = pathinfo($request->input('url'), PATHINFO_EXTENSION);
        $data   = file_get_contents($request->input('url'));
        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
        return response()
            ->json($base64)
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end encodeImage()

}//end class
