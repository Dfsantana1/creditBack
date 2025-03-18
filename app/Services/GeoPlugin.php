<?php

namespace App\Services;

/**
 * Class
 *
 * @category GeoPlugin
 * @package  App\Functions

 */
class GeoPlugin
{

    /**
     * @var string
     */
    public string $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}&lang={LANG}';

    /**
     * @var string
     */
    public string $currency = 'USD';

    /**
     * @var string
     */
    public string $lang = 'en';

    /**
     * @var string
     */
    public string $ip = '';

    /**
     * @var string
     */
    public string $city = '';

    /**
     * @var string
     */
    public string $region = '';

    /**
     * @var string
     */
    public string $regionCode = '';

    /**
     * @var string
     */
    public string $regionName = '';

    /**
     * @var string
     */
    public string $dmaCode = '';

    /**
     * @var string
     */
    public string $countryCode = '';

    /**
     * @var string
     */
    public string $countryName = '';

    /**
     * @var string
     */
    public string $inEU = '';

    /**
     * @var string
     */
    public string $euVATrate = '';

    /**
     * @var string
     */
    public string $continentCode = '';

    /**
     * @var string
     */
    public string $continentName = '';

    /**
     * @var string
     */
    public string $latitude = '';

    /**
     * @var string
     */
    public string $longitude = '';

    /**
     * @var string
     */
    public string $locationAccuracyRadius = '';

    /**
     * @var string
     */
    public string $timezone = '';

    /**
     * @var string
     */
    public string $currencyCode = '';

    /**
     * @var string
     */
    public string $currencySymbol = '';

    /**
     * @var string
     */
    public string $currencyConverter = '';


    /**
     * @param  string $ip
     * @return void
     */
    public function locate(string $ip=''): void
    {
        global $_SERVER;
        if (empty($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if (env('APP_ENV') === 'local') {
            $ip = '';
        }

        $host = str_replace('{IP}', $ip, $this->host);
        $host = str_replace('{CURRENCY}', $this->currency, $host);
        $host = str_replace('{LANG}', $this->lang, $host);

        $this->host = $host;
        $response   = $this->fetch($host);
        $data       = unserialize($response);
        //set the geoPlugin vars
        $this->ip          = $ip;
        $this->city        = (isset($data['geoplugin_city'])) ? $data['geoplugin_city'] : '';
        $this->region      = (isset($data['geoplugin_region'])) ? $data['geoplugin_region'] : '';
        $this->regionCode  = (isset($data['geoplugin_regionCode'])) ? $data['geoplugin_regionCode'] : '';
        $this->regionName  = (isset($data['geoplugin_regionName'])) ? $data['geoplugin_regionName'] : '';
        $this->dmaCode     = (isset($data['geoplugin_dmaCode'])) ? $data['geoplugin_dmaCode'] : '';
        $this->countryCode = (isset($data['geoplugin_countryCode'])) ? $data['geoplugin_countryCode'] : '';
        $this->countryName = (isset($data['geoplugin_countryName'])) ? $data['geoplugin_countryName'] : '';
        $this->inEU        = (isset($data['geoplugin_inEU'])) ? $data['geoplugin_inEU'] : '';
        //        $this->euVATrate              = $data['euVATrate'];
        $this->continentCode = (isset($data['geoplugin_continentCode'])) ? $data['geoplugin_continentCode'] : '';
        $this->continentName = (isset($data['geoplugin_continentName'])) ? $data['geoplugin_continentName'] : '';
        $this->latitude      = (isset($data['geoplugin_latitude'])) ? $data['geoplugin_latitude'] : '';
        $this->longitude     = (isset($data['geoplugin_longitude'])) ? $data['geoplugin_longitude'] : '';
        $this->locationAccuracyRadius = (isset($data['geoplugin_locationAccuracyRadius'])) ? $data['geoplugin_locationAccuracyRadius'] : '';
        $this->timezone          = (isset($data['geoplugin_timezone'])) ? $data['geoplugin_timezone'] : '';
        $this->currencyCode      = (isset($data['geoplugin_currencyCode'])) ? $data['geoplugin_currencyCode'] : '';
        $this->currencySymbol    = (isset($data['geoplugin_currencySymbol'])) ? $data['geoplugin_currencySymbol'] : '';
        $this->currencyConverter = (isset($data['geoplugin_currencyConverter'])) ? $data['geoplugin_currencyConverter'] : '';

    }//end locate()


    /**
     * @param  $host
     * @return string|bool
     */
    protected function fetch($host): string|bool
    {

        if (function_exists('curl_init')) {
            //use cURL to fetch data
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.1');
            $response = curl_exec($ch);
            curl_close($ch);
        } else {
            if (ini_get('allow_url_fopen')) {
                //fall back to fopen()
                $response = file_get_contents($host, 'r');
            } else {
                trigger_error('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
            }
        }

        return $response;

    }//end fetch()


    /**
     * @param  $amount
     * @param  float $float
     * @param  bool  $symbol
     * @return float|mixed|string
     */
    public function convert($amount, float $float=2, bool $symbol=true): mixed
    {

        //easily convert amounts to geolocated currency.
        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
            return $amount;
        }

        if (!is_numeric($amount)) {
            trigger_error('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
            return $amount;
        }

        if ($symbol === true) {
            return $this->currencySymbol.round(($amount * $this->currencyConverter), $float);
        } else {
            return round(($amount * $this->currencyConverter), $float);
        }

    }//end convert()


    /**
     * @param  int $radius
     * @param  $limit
     * @return array[]|mixed
     */
    public function nearby(int $radius=10, $limit=null): mixed
    {

        if (!is_numeric($this->latitude) || !is_numeric($this->longitude)) {
            trigger_error('geoPlugin class Warning: Incorrect latitude or longitude values.', E_USER_NOTICE);
            return [[]];
        }

        $host = "http://www.geoplugin.net/extras/nearby.gp?lat=".$this->latitude."&long=".$this->longitude."&radius={$radius}";

        if (is_numeric($limit)) {
            $host .= "&limit={$limit}";
        }

        return unserialize($this->fetch($host));

    }//end nearby()


}//end class
