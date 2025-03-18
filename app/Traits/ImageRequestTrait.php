<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Class ImageRequestTrait
 *
 * @category Request
 * @package  App\Traits

 */
trait ImageRequestTrait
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @param  bool $fileRequired
     * @return array
     */
    public function getImageRequest(bool $fileRequired=false): array
    {

        $requiredValues = (!$fileRequired) ? ['mimes:jpg,bmp,png,gif,pdf,avi,mp3,mp4,wav,m4a,webm,csv,txt,xlsx,xls,xlsm,csv,docx,dotx,dot,doc,txt,ppt,pptx,pps,ppsx,pot,potx'] : [
            'required',
            'mimes:jpg,bmp,png,gif,pdf,avi,mp3,mp4,wav,m4a,webm,csv,txt,xlsx,xls,xlsm,csv,docx,dotx,dot,doc,txt,ppt,pptx,pps,ppsx,pot,potx',
        ];

        return [
            'resizeWidth'  => [
                'numeric',
                'gte:30',
            ],
            'resizeHeight' => [
                'numeric',
                'gte:30',
            ],
            'rotateDeg'    => [
                'numeric',
                'gt:0',
                'lt:360',
            ],
            'cropPosX'     => [
                'numeric',
                'gt:0',
            ],
            'cropPosY'     => [
                'numeric',
                'gt:0',
                'lt:360',
            ],
            'cropWidth'    => [
                'numeric',
                'gt:0',
            ],
            'cropHeight'   => [
                'numeric',
                'gt:0',
            ],
            'file'         => $requiredValues,
        ];

    }//end getImageRequest()


}//end class
