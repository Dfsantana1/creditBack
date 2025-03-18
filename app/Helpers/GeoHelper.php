<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Services\GeoPlugin;
use Illuminate\Support\Collection;

/**
 * Class GeoHelper
 *
 * @category Helpers
 * @package  App\Helpers

 */
class GeoHelper
{


    /**
     * Get GeoLocation Data
     *
     * @return Collection
     */
    public static function getGeoLocation(): Collection
    {
        try {
            $geo = new GeoPlugin();
            $geo->locate();
            return collect($geo);
        } catch (\Exception $e) {
            // TODO
            return collect([]);
        }

    }//end getGeoLocation()


}//end class
