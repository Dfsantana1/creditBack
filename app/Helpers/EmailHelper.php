<?php
declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class EmailHelper
 *
 * @category Helpers
 * @package  App\Helpers
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class EmailHelper
{


    /**
     * Verify email address using mailgun API
     *
     * @param  $email
     * @return array
     */
    public static function verifyEmail($email): array
    {
        try {
            $mailGunSecret = config('services.mailgun.secret');
            $response      = Http::withBasicAuth('api', $mailGunSecret)
                ->retry(3, 1000)
                ->get(
                    'https://api.mailgun.net/v4/address/validate',
                    ['address' => $email]
                );

            return [
                'success' => true,
                'data'    => $response->json(),
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }//end try

    }//end verifyEmail()


    /**
     * Get sent emails sent status using mailgun API by date range
     *
     * @param  Carbon $startDate
     * @param  Carbon $endDate
     * @return array
     */
    public static function verifyEmailStatus(Carbon $startDate, Carbon $endDate): array
    {
        $mailGunSecret = config('services.mailgun.secret');
        $domain        = config('services.mailgun.domain');
        $endPoint      = "https://api.mailgun.net/v3/{$domain}/events";
        $response      = Http::withBasicAuth('api', $mailGunSecret)
            ->retry(3, 1000)
            ->get(
                $endPoint,
                [
                    'begin' => $startDate->timestamp,
                    'end'   => $endDate->timestamp,
                ]
            );

        return [
            'success' => true,
            'data'    => $response->json(),
        ];

    }//end verifyEmailStatus()


}//end class
