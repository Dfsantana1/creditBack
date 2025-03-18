<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Models\Media\Media;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class ImageHelper
 *
 * @category Helpers
 * @package  App\Helpers

 */
class ImageHelper
{


    /**
     * Check if remote resource exist
     *
     * @param  string $url
     * @return bool
     */
    public static function fileExists(string $url): bool
    {
        $handle = @fopen($url, 'r');
        return !!$handle;

    }//end fileExists()


    /**
     * Check if remote resource exist
     *
     * @param  string $url
     * @return array|null
     */
    public static function getMediaValuesForUrl(string $url): array|null
    {
        $remoteUrl   = 'https://s3.amazonaws.com/';
        $bucket      = str_replace($remoteUrl, '', $url);
        $bucketPr    = explode('/', $bucket);
        $bucket      = $bucketPr[0];
        $resource    = ltrim(str_replace([$remoteUrl, $bucket], '', $url), '/');
        $headers     = get_headers($url);
        $resultArray = array_filter(
            $headers,
            function ($key) {
                return str_starts_with($key, 'Content-Type');
            },
            ARRAY_FILTER_USE_BOTH
        );
        if (empty($resultArray)) {
            return null;
        }

        $resultArray = array_values($resultArray);
        $mimeType    = trim(str_replace('Content-Type:', '', $resultArray[0]));
        $exploded    = explode('/', $mimeType);
        return [
            'name'       => basename($url),
            'fileType'   => $mimeType,
            'extension'  => pathinfo($url, PATHINFO_EXTENSION),
            'source'     => 'UNKNOWN',
            'bucketName' => $bucket,
            'resource'   => $resource,
            'url'        => $url,
            'type'       => strtoupper($exploded[0]),
        ];

    }//end getMediaValuesForUrl()


    /**
     * @param  string $mediaId
     * @param  int    $minutes
     * @return string
     */
    public static function getTemporalFileUrl(string $mediaId, int $minutes=10): string
    {
        // Define Bucket System
        $media          = Media::find($mediaId);
        $bucket         = $media->bucketName;
        $bucketSystemId = 's3';
        if ($bucket === 'alpha.tsolife.com') {
            $bucketSystemId = 's3OldAlphaBucket';
        } else {
            if ($bucket === 'dev.tsolife.com') {
                $bucketSystemId = 's3OldDevBucket';
            }
        }

        return Storage::disk($bucketSystemId)
            ->temporaryUrl($media->resource, now()->addMinutes($minutes));

    }//end getTemporalFileUrl()


    /**
     * @param  string $bucket
     * @param  string $resource
     * @param  int    $minutes
     * @return string
     */
    public static function getTemporalFileUrlFromUrl(string $bucket, string $resource, int $minutes=10): string
    {
        // Define Bucket System
        $bucketSystemId = 's3';
        if ($bucket === 'alpha.tsolife.com') {
            $bucketSystemId = 's3OldAlphaBucket';
        } else {
            if ($bucket === 'dev.tsolife.com') {
                $bucketSystemId = 's3OldDevBucket';
            }
        }

        return Storage::disk($bucketSystemId)
            ->temporaryUrl($resource, now()->addMinutes($minutes));

    }//end getTemporalFileUrlFromUrl()


    /**
     * @param  string $contentType
     * @return bool
     */
    public static function getValidImageType(string $contentType): bool
    {
        $validTypes = [
            'image/apng',
            'image/avif',
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/svg+xml',
        ];
        return in_array($contentType, $validTypes);

    }//end getValidImageType()


    /**
     * Attempts to fix image orientation
     *
     * @param  Media|null $media
     * @return string
     */
    public static function fixImageOrientation(Media|null $media): string
    {
        $imageUrl = ($media->url ?? "");
        $tmpDir   = 'tmp';
        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $fileName      = $tmpDir.DIRECTORY_SEPARATOR.$media->name;
            $localFileName = public_path().DIRECTORY_SEPARATOR.$tmpDir.DIRECTORY_SEPARATOR.$media->name;
            Storage::disk('public')->put($fileName, file_get_contents($imageUrl), 'public');
            $rotate = 0;
            $image  = Image::make($localFileName);
            $exif   = @exif_read_data($localFileName, '0', true);
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

            $image->rotate($rotate);
            $image->save($localFileName);
            $imageUrl = $localFileName;
        }//end if

        return $imageUrl;

    }//end fixImageOrientation()


}//end class
