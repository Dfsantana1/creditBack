<?php
declare(strict_types=1);

namespace App\Traits;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;

/**
 * Class UploadTrait
 *
 * @category Traits
 * @package  App\Traits

 */
trait UtilizesFFMpeg
{


    /**
     *  Use FFMPeg Library
     *
     * @return FFMpeg
     */
    protected static function getFFMpeg(): FFMpeg
    {
        return FFMpeg::create(
            [
                'ffmpeg.binaries'  => config('services.ffmpeg.binary'),
                'ffprobe.binaries' => config('services.ffprobe.binary'),
                'timeout'          => 10000,
            ]
        );

    }//end getFFMpeg()


    /**
     * User FFProb Library
     *
     * @return FFProbe
     */
    protected static function getFFProbe(): FFProbe
    {
        return FFProbe::create(
            [
                'ffprobe.binaries' => config('services.ffprobe.binary'),
            ]
        );

    }//end getFFProbe()


}
