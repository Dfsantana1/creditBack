<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Class LocationHelper
 *
 * @category Helpers
 * @package  App\Helpers

 */
class LocationHelper
{


    /**
     * Get Address Values Given Address Component
     *
     * @param  array $addressComponents
     * @return array
     */
    public static function mapLocation(array $addressComponents): array
    {

        $shouldBeComponent = [
            'street'  => ["street_number"],
            'route'   => ["route"],
            'zip'     => ["postal_code"],
            'state'   => [
                "administrative_area_level_1",
                "administrative_area_level_2",
                "administrative_area_level_3",
                "administrative_area_level_4",
                "administrative_area_level_5",
            ],
            'city'    => [
                "locality",
                "sublocality",
                "sublocality_level_1",
                "sublocality_level_2",
                "sublocality_level_3",
                "sublocality_level_4",
            ],
            'country' => ["country"],
        ];

        $address = [
            'zip'     => '',
            'state'   => '',
            'city'    => '',
            'country' => '',
            'street'  => '',
            'route'   => '',
        ];

        foreach ($addressComponents as $component) {
            foreach ($shouldBeComponent as $key => $sbComponent) {
                if (in_array($component['types'][0], $sbComponent)) {
                    if ($key === 'country') {
                        $address[$key] = $component['long_name'];
                    } else {
                        $address[$key] = $component['short_name'];
                    }
                }
            }
        }

        $address['line1'] = $address['street'].' '.$address['route'];
        unset($address['street']);
        unset($address['route']);

        return $address;

    }//end mapLocation()


    /**
     * Get Address Values Given Address Component
     *
     * @param  array $addressComponents
     * @return array
     */
    public static function mapLocationSTDClass(array $addressComponents): array
    {
        $address = [];
        foreach ($addressComponents as $component) {
            switch ($component->types[0]) {
            case 'postal_code':
                $address['zip'] = $component->long_name;
                break;
            case 'country':
                $address['country'] = $component->long_name;
                break;
            case 'administrative_area_level_1':
                   $address['state'] = $component->long_name;
                break;
            case 'locality':
                $address['city'] = $component->long_name;
                break;
            }
        }

        return $address;

    }//end mapLocationSTDClass()


    /**
     * Geocode address
     *
     * @param  string|null $address
     * @return mixed
     */
    public static function geoCodeAddress(string|null $address): object
    {
        if (empty($address)) {
            return (object) ['status' => 'Fail'];
        }

        $apiKey  = env('GOOGLE_MAPS_ENCODER_API_KEY');
        $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
        return json_decode($geocode);

    }//end geoCodeAddress()


}//end class
