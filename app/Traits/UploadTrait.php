<?php
declare(strict_types=1);

namespace App\Traits;

use App\Enums\ImageSizeEnum;
use App\Helpers\ImageHelper;
use App\Models\Media\Media;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class UploadTrait
 *
 * @category Traits
 * @package  App\Traits

 */
trait UploadTrait
{

    /**
     * @var string $bucket
     */
    protected string $bucket;

    /**
     * @var integer $maxWidth
     */
    protected int $maxWidth = 1200;

    /**
     * @var integer $maxHeight
     */
    protected int $maxHeight = 1600;

    /**
     * @var integer $thumbWidth
     */
    protected int $thumbWidth = 250;

    /**
     * @var integer $thumbHeight ;
     */
    protected int $thumbHeight = 320;

    /**
     * @var string $originalName
     */
    protected string $originalName;

    /**
     * @var string $contentType
     */
    protected string $contentType;

    /**
     * @var string $size
     */
    protected string $size;

    /**
     * @var string $folder
     */
    protected string $folder;

    /**
     * @var string $source
     */
    protected string $source;

	/**
     * @var integer $bytesSize
     */
    protected ?string $bytesSize = null;

    /**
     * @var mixed $uploadByUserId
     */
    protected mixed $uploadByUserId;

    /**
     * @var mixed $resource
     */
    protected mixed $resource;

    /**
     * @var string $remotePath
     */
    protected string $remotePath;

    /**
     * @var mixed $file
     */
    protected mixed $file;

    /**
     * @var object|null $object
     */
    protected ?object $object;

    /**
     * @var Media $parent
     */
    protected Media $parent;


    /**
     * UploadTrait File
     *
     * @param  array $files
     * @param  $object
     * @return array|bool
     */
    public function storeUploadedFile(array $files, $object, $parent = null): array|bool
    {
        $response     = [];
        $this->folder = date('Y-m-d');
        $this->uploadByUserId = (auth('sanctum')->user()) ? auth('sanctum')->user()->id : null;
        $this->object         = $object;
        $this->source         = request()->get('source', 'UNKNOWN');
		$this->bytesSize         = request()->get('bytesSize');

        foreach ($files as $file) {
            try {
                $this->file         = $file;
                $this->originalName = $file->getClientOriginalName();
                $this->contentType  = $file->getClientMimeType();

                if (ImageHelper::getValidImageType($this->contentType)) {
                    $rotate = 0;
                    $exif   = @exif_read_data($file, '0', true);
                    if (!empty($exif['IFD0']['Orientation'])) {
                        switch ($exif['IFD0']['Orientation']) {
                        case 8:
                            $rotate = 90;
                            break;
                        case 3:
                            $rotate = 180;
                            break;
                        case 6:
                                     $rotate = -90;
                            break;
                        }
                    }

                    // Getting issues with large images. reduce
                    $height = Image::make($file)->height();
                    $width  = Image::make($file)->width();

                    $this->originalName = $file->getClientOriginalName();
                    $this->contentType  = $file->getClientMimeType();
                    $this->file         = $file;

                    if ($width >= $this->maxWidth || $height >= $this->maxHeight) {
                        $this->resizeImage($this->maxWidth, $this->maxHeight, true, $rotate);
                    } else {
                        $this->uploadS3File();
                    }

                    /***
                     * InsightCreate Media
                     */
                    $this->size = ImageSizeEnum::ORIGINAL->name;
                    $media      = $this->createMedia();
                    $response[] = $media;

                    /***
                     * InsightCreate Thumbnail
                     */
                    [
                        $width,
                        $height,
                    ] = getimagesize($this->remotePath);
                    if ($width > $this->thumbWidth || $height > $this->maxHeight) {
                        $this->resizeImage($this->thumbWidth, $this->thumbHeight);
                        $this->size   = ImageSizeEnum::THUMBNAIL->name;
                        $this->parent = $media;
                        $this->createMedia();
                    }

                    /**
                     * Custom Modification Thumbnail
                     */
                    if ((request()->has('resizeWidth') && request()->has('resizeHeight'))
                        || request()->has('rotateDeg')
                        || (request()->has('cropPosX') || request()->has('cropPosY'))
                        || (request()->has('cropWidth') || request()->has('cropHeight'))
                    ) {
                        $this->modifyImage();
                        $this->size   = ImageSizeEnum::CUSTOM->name;
                        $this->parent = $media;
                        $this->createMedia();
                    }
                } else {
					if($parent){
						$this->parent = $parent;
					}
                    $this->uploadS3File();
                    $this->size = ImageSizeEnum::ORIGINAL->name;
                    $media      = $this->createMedia();
                    $response[] = $media;
                }//end if
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }//end try
        }//end foreach

        return $response;

    }//end storeUploadedFile()


    /**
     * @param  Media $media
     * @return void
     */
    public function deleteUploadedFile(Media $media): void
    {
        $bucketName = match ($media->bucketName) {
            'alpha.tsolife.com' => 's3OldAlphaBucket',
            'dev.tsolife.com' => 's3OldDevBucket',
            'production.tsolife.com' => 's3OldProductionBucket',
            default => 's3'
        };

        try {
            Storage::disk($bucketName)->delete($media->resource);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

    }//end deleteUploadedFile()


    /**
     * UploadTrait File to AWS S3
     *
     * @return void
     */
    protected function uploadS3File(): void
    {
        $resource         = Storage::disk('s3')->put($this->folder, $this->file, 'public');
        $this->remotePath = Storage::disk('s3')->url($resource);
        $this->resource   = ''.$resource;

    }//end uploadS3File()


    /**
     * InsightCreate Media
     *
     * @return Media
     */
    protected function createMedia(): Media
    {
        [
            $width,
            $height,
        ]            = getimagesize($this->remotePath);
        $media       = new Media();
        $media->name = $this->originalName;
        $media->fileType       = $this->contentType;
        $media->type           = strtok($this->contentType, '/');
        $media->extension      = pathinfo($this->originalName, PATHINFO_EXTENSION);
        $media->source         = $this->source;
		$media->bytesSize         = $this->bytesSize;
        $media->bucketName     = env('AWS_BUCKET') ?? 'ecommercewgs';
        $media->resource       = $this->resource;
        $media->url            = $this->remotePath;
        $media->mediableId     = ($this->object) ? $this->object->id : null;
        $media->mediableType   = ($this->object) ? get_class($this->object) : null;
        $media->uploadByUserId = $this->uploadByUserId;
        $media->width          = $width;
        $media->height         = $height;
        $media->size           = $this->size;
        $media->parentId       = (!empty($this->parent)) ? $this->parent->id : null;
        $media->save();
        return $media;

    }//end createMedia()


    /**
     * Resize Image
     *
     * @param  int  $width
     * @param  int  $height
     * @param  bool $isOriginal
     * @param  int  $rotateDegrees
     * @return void
     */
    protected function resizeImage(int $width, int $height, bool $isOriginal=false, int $rotateDegrees=0): void
    {
        $extension    = $this->getExtension();
        $filename     = uniqid().'.'.$extension;
        $localResult  = storage_path('tmp').$filename;
        $remoteResult = $this->folder.'/'.$filename;

        $img = Image::make($this->file->path());
        $img->resize(
            $width,
            $height,
            function ($const) {
                $const->aspectRatio();
            }
        )
        ->rotate($rotateDegrees)
        ->encode('jpg', 75)
        ->save($localResult);

        $resource       = $this->getImageResource($img);
        $this->resource = $remoteResult;
        Storage::disk('s3')->put($remoteResult, $resource, 'public');
        $this->remotePath = Storage::disk('s3')->url($this->resource);
        [
            $width,
            $height,
        ] = getimagesize($this->remotePath);

        if (!$isOriginal) {
            $this->originalName = $width.'x'.$height.'_'.$this->originalName;
        }

        unlink($localResult);

    }//end resizeImage()


    /**
     * Modify Image
     *
     * @return void
     */
    protected function modifyImage(): void
    {
        $extension      = $this->getExtension();
        $filename       = uniqid().'.'.$extension;
        $localResult    = storage_path('tmp').$filename;
        $remoteResult   = $this->folder.'/'.$filename;
        $prefixFileName = 'Modified';

        $img = Image::make($this->file->path());

        if (request()->has('resizeWidth') && request()->has('resizeHeight')) {
            $img->resize(request()->input('resizeWidth'), request()->input('resizeHeight'));
            $prefixFileName .= '_'.request()->input('resizeWidth').'x'.request()->input('resizeHeight');
        }

        if (request()->has('rotateDeg')) {
            $img->rotate(request()->input('rotateDeg'));
            $prefixFileName .= '_rotate_'.request()->input('rotateDeg');
        }

        $cropPosX = request()->input('cropPosX', 0);
        $cropPosY = request()->input('cropPosY', 0);

        if (($cropPosX || $cropPosY) && request()->has('cropWidth') && request()->has('cropHeight')) {
            $img->crop(request()->input('cropWidth'), request()->input('cropHeight'), $cropPosX, $cropPosY);
            $prefixFileName .= '_crop';
        }

        $img->save($localResult);
        $resource       = $this->getImageResource($img);
        $this->resource = $remoteResult;
        Storage::disk('s3')->put($remoteResult, $resource, 'public');
        $this->remotePath   = Storage::disk('s3')->url($this->resource);
        $this->originalName = $prefixFileName.'_'.$this->originalName;
        unlink($localResult);

    }//end modifyImage()


    /**
     * Get Extension Filename
     *
     * @return string
     */
    protected function getExtension(): string
    {
        return pathinfo($this->originalName, PATHINFO_EXTENSION);

    }//end getExtension()


    /**
     * @param  $img
     * @return mixed
     */
    protected function getImageResource($img): mixed
    {
        return $img->stream()->detach();

    }//end getImageResource()


    /**
     * Download File from S3
     *
     * @param  Media  $media
     * @param  string $folder
     * @return Collection
     */
    protected function downloadS3File(Media $media, string $folder='tmp'): Collection
    {
        # Because we have LoadBalancer no reason to have files in own servers
        # Use just for temporal process, needs to be deleted after use
        $fileName      = 'tmp'.DIRECTORY_SEPARATOR.$media->name;
        $localFileName = public_path().DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.$media->name;
        if (Storage::disk('public')->exists($fileName)) {
            return collect(
                [
                    'status'        => true,
                    'localFileName' => $localFileName,
                ]
            );
        }

        try {
            Storage::disk('public')->put($fileName, file_get_contents($media->url), 'public');
            return collect(
                [
                    'status'        => true,
                    'localFileName' => $localFileName,
                ]
            );
        } catch (\Throwable $e) {
            Log::alert('Cant Download File Reason : '.$e->getMessage());
            return collect(
                [
                    'status' => false,
                    'reason' => $e->getMessage(),
                ]
            );
        }

    }//end downloadS3File()


}
