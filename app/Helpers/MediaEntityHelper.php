<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\MediaEntityTypeEnum;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\User\UserResource;

/**
 * Class MediaEntityHelper
 *
 * @category Helpers
 * @package  App\Helpers
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityHelper
{


    /**
     * Get Entity Type Class
     *
     * @param string $entityType
     *
     * @return string|null
     */
    public static function getEntityTypeClass(string $entityType): string|null
    {
        $mediaEntityType = collect(MediaEntityTypeEnum::cases())->filter(
            function ($case) use ($entityType) {
                return $case->name === $entityType;
            }
        )->first();

        return $mediaEntityType ? $mediaEntityType->value : null;

    }//end getEntityTypeClass()


    /**
     * Get type from entity class
     *
     * @param string $entityTypeClass
     *
     * @return string|null
     */
    public static function getEntityType(string $entityTypeClass): string|null
    {
        $mediaEntityType = collect(MediaEntityTypeEnum::cases())->filter(
            function ($case) use ($entityTypeClass) {
                return $case->value === $entityTypeClass;
            }
        )->first();

        return $mediaEntityType ? $mediaEntityType->name : null;

    }//end getEntityType()


    /**
     * Get available media entity types
     *
     * @return array
     */
    public static function getMediaEntityTypes(): array
    {
        return collect(MediaEntityTypeEnum::cases())->pluck('name')->toArray();

    }//end getMediaEntityTypes()

}//end class
