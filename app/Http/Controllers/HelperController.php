<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EmailTrackingTypes;
use App\Enums\SentEmailStatus;
use App\Http\Requests\InquiryRequest;
use App\Mail\SendInquiryWebsite;
use App\Models\EmailTracking\EmailTracking;
use App\Models\Interest\QOLDimension;
use App\Models\User\Relationship;
use App\Services\Okta\LoginService;
use DateTimeZone;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class HelperController
 *
 * @extends  Controller
 * @category Controllers
 * @package  App\Http\Controllers
 * @author   Mauricio T <mauricio@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class HelperController extends Controller
{
    /**
     * @return JsonResponse
     * @throws Exception
     */
    protected function getTimezoneList(): JsonResponse
    {
        $list = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        return response()
            ->json($list)
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getTimezoneList()


    /**
     * @param  InquiryRequest $request
     * @return JsonResponse
     */
    protected function sendEmail(InquiryRequest $request): JsonResponse
    {
        $to = new Address(env('MAIL_FROM_ADDRESS', 'support@tsolife.com'), env('MAIL_FROM_NAME', 'TSOLife'));

        $response = Mail::to($to)->send(new SendInquiryWebsite($request));

        $html = view('mail.inquiry', ['request' => $request])->render();

        EmailTracking::create(
            [
                'emailId'  => Str::replace(["<", ">"], "", $response->getMessageId()),
                'sender'   => $response->getEnvelope()->getSender()->getAddress(),
                'receiver' => env('MAIL_FROM_ADDRESS', 'support@tsolife.com'),
                'body'     => $html,
                'userId'   => null,
                'active'   => 1,
                'status'   => SentEmailStatus::QUEUE->value,
                'type'     => EmailTrackingTypes::INQUIRY->value,
            ]
        );
        return response()
            ->json($response)
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end sendEmail()


    /**
     * @return JsonResponse
     */
    protected function getTimezoneWithOffset(): JsonResponse
    {
        $list = [
            [
                'key'   => 'Pacific/Midway',
                'value' => '(GMT-11:00) Midway Island, Samoa',
            ],
            [
                'key'   => 'America/Adak',
                'value' => '(GMT-10:00) Hawaii-Aleutian',
            ],
            [
                'key'   => 'Pacific/Marquesas',
                'value' => '(GMT-09:30) Marquesas Islands',
            ],
            [
                'key'   => 'Pacific/Gambier',
                'value' => '(GMT-09:00) Gambier Islands',
            ],
            [
                'key'   => 'America/Anchorage',
                'value' => '(GMT-09:00) Alaska',
            ],
            [
                'key'   => 'America/Ensenada',
                'value' => '(GMT-08:00) Tijuana, Baja California',
            ],
            [
                'key'   => 'America/Los_Angeles',
                'value' => '(GMT-08:00) Pacific Time (US & Canada)',
            ],
            [
                'key'   => 'America/Denver',
                'value' => '(GMT-07:00) Mountain Time (US & Canada)',
            ],
            [
                'key'   => 'America/Chihuahua',
                'value' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan',
            ],
            [
                'key'   => 'America/Dawson_Creek',
                'value' => '(GMT-07:00) Arizona',
            ],
            [
                'key'   => 'America/Belize',
                'value' => '(GMT-06:00) Saskatchewan, Central America',
            ],
            [
                'key'   => 'America/Cancun',
                'value' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey',
            ],
            [
                'key'   => 'Chile/EasterIsland',
                'value' => '(GMT-06:00) Easter Island',
            ],
            [
                'key'   => 'America/Chicago',
                'value' => '(GMT-06:00) Central Time (US & Canada)',
            ],
            [
                'key'   => 'America/New_York',
                'value' => '(GMT-05:00) Eastern Time (US & Canada)',
            ],
            [
                'key'   => 'America/Havana',
                'value' => '(GMT-05:00) Cuba',
            ],
            [
                'key'   => 'America/Bogota',
                'value' => '(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
            ],
            [
                'key'   => 'America/Caracas',
                'value' => '(GMT-04:30) Caracas',
            ],
            [
                'key'   => 'America/Santiago',
                'value' => '(GMT-04:00) Santiago',
            ],
            [
                'key'   => 'America/La_Paz',
                'value' => '(GMT-04:00) La Paz',
            ],
            [
                'key'   => 'Atlantic/Stanley',
                'value' => '(GMT-04:00) Faukland Islands',
            ],
            [
                'key'   => 'America/Campo_Grande',
                'value' => '(GMT-04:00) Brazil',
            ],
            [
                'key'   => 'America/Goose_Bay',
                'value' => '(GMT-04:00) Atlantic Time (Goose Bay)',
            ],
            [
                'key'   => 'America/Glace_Bay',
                'value' => '(GMT-04:00) Atlantic Time (Canada)',
            ],
            [
                'key'   => 'America/St_Johns',
                'value' => '(GMT-03:30) Newfoundland',
            ],
            [
                'key'   => 'America/Araguaina',
                'value' => '(GMT-03:00) Araguaina',
            ],
            [
                'key'   => 'America/Montevideo',
                'value' => '(GMT-03:00) Montevideo',
            ],
            [
                'key'   => 'America/Miquelon',
                'value' => '(GMT-03:00) Miquelon, St. Pierre',
            ],
            [
                'key'   => 'America/Godthab',
                'value' => '(GMT-03:00) Greenland',
            ],
            [
                'key'   => 'America/Argentina/Buenos_Aires',
                'value' => '(GMT-03:00) Buenos Aires',
            ],
            [
                'key'   => 'America/Sao_Paulo',
                'value' => '(GMT-03:00) Brasilia',
            ],
            [
                'key'   => 'America/Noronha',
                'value' => '(GMT-02:00) Mid-Atlantic',
            ],
            [
                'key'   => 'Atlantic/Cape_Verde',
                'value' => '(GMT-01:00) Cape Verde Is.',
            ],
            [
                'key'   => 'Atlantic/Azores',
                'value' => '(GMT-01:00) Azores',
            ],
            [
                'key'   => 'UTC',
                'value' => 'UTC TimeZone',
            ],
            [
                'key'   => 'Europe/Belfast',
                'value' => '(GMT) Greenwich Mean Time : Belfast',
            ],
            [
                'key'   => 'Europe/Dublin',
                'value' => '(GMT) Greenwich Mean Time : Dublin',
            ],
            [
                'key'   => 'Europe/Lisbon',
                'value' => '(GMT) Greenwich Mean Time : Lisbon',
            ],
            [
                'key'   => 'Europe/London',
                'value' => '(GMT) Greenwich Mean Time : London',
            ],
            [
                'key'   => 'Africa/Abidjan',
                'value' => '(GMT) Monrovia, Reykjavik',
            ],
            [
                'key'   => 'Europe/Amsterdam',
                'value' => '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
            ],
            [
                'key'   => 'Europe/Belgrade',
                'value' => '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
            ],
            [
                'key'   => 'Europe/Brussels',
                'value' => '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris',
            ],
            [
                'key'   => 'Africa/Algiers',
                'value' => '(GMT+01:00) West Central Africa',
            ],
            [
                'key'   => 'Africa/Windhoek',
                'value' => '(GMT+01:00) Windhoek',
            ],
            [
                'key'   => 'Asia/Beirut',
                'value' => '(GMT+02:00) Beirut',
            ],
            [
                'key'   => 'Africa/Cairo',
                'value' => '(GMT+02:00) Cairo',
            ],
            [
                'key'   => 'Asia/Gaza',
                'value' => '(GMT+02:00) Gaza',
            ],
            [
                'key'   => 'Africa/Blantyre',
                'value' => '(GMT+02:00) Harare, Pretoria',
            ],
            [
                'key'   => 'Europe/Helsinki',
                'value' => '(GMT+2:00) Helsinki',
            ],
            [
                'key'   => 'Asia/Jerusalem',
                'value' => '(GMT+02:00) Jerusalem',
            ],
            [
                'key'   => 'Europe/Minsk',
                'value' => '(GMT+02:00) Minsk',
            ],
            [
                'key'   => 'Asia/Damascus',
                'value' => '(GMT+02:00) Syria',
            ],
            [
                'key'   => 'Europe/Moscow',
                'value' => '(GMT+03:00) Moscow, St. Petersburg, Volgograd',
            ],
            [
                'key'   => 'Africa/Addis_Ababa',
                'value' => '(GMT+03:00) Nairobi',
            ],
            [
                'key'   => 'Asia/Tehran',
                'value' => '(GMT+03:30) Tehran',
            ],
            [
                'key'   => 'Asia/Dubai',
                'value' => '(GMT+04:00) Abu Dhabi, Muscat',
            ],
            [
                'key'   => 'Asia/Yerevan',
                'value' => '(GMT+04:00) Yerevan',
            ],
            [
                'key'   => 'Asia/Kabul',
                'value' => '(GMT+04:30) Kabul',
            ],
            [
                'key'   => 'Asia/Yekaterinburg',
                'value' => '(GMT+05:00) Ekaterinburg',
            ],
            [
                'key'   => 'Asia/Tashkent',
                'value' => '(GMT+05:00) Tashkent',
            ],
            [
                'key'   => 'Asia/Kolkata',
                'value' => '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
            ],
            [
                'key'   => 'Asia/Kathmandu',
                'value' => '(GMT+05:45) Kathmandu',
            ],
            [
                'key'   => 'Asia/Dhaka',
                'value' => '(GMT+06:00) Astana, Dhaka',
            ],
            [
                'key'   => 'Asia/Novosibirsk',
                'value' => '(GMT+06:00) Novosibirsk',
            ],
            [
                'key'   => 'Asia/Rangoon',
                'value' => '(GMT+06:30) Yangon (Rangoon)',
            ],
            [
                'key'   => 'Asia/Bangkok',
                'value' => '(GMT+07:00) Bangkok, Hanoi, Jakarta',
            ],
            [
                'key'   => 'Asia/Krasnoyarsk',
                'value' => '(GMT+07:00) Krasnoyarsk',
            ],
            [
                'key'   => 'Asia/Hong_Kong',
                'value' => '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
            ],
            [
                'key'   => 'Asia/Irkutsk',
                'value' => '(GMT+08:00) Irkutsk, Ulaan Bataar',
            ],
            [
                'key'   => 'Australia/Perth',
                'value' => '(GMT+08:00) Perth',
            ],
            [
                'key'   => 'Australia/Eucla',
                'value' => '(GMT+08:45) Eucla',
            ],
            [
                'key'   => 'Asia/Tokyo',
                'value' => '(GMT+09:00) Osaka, Sapporo, Tokyo',
            ],
            [
                'key'   => 'Asia/Seoul',
                'value' => '(GMT+09:00) Seoul',
            ],
            [
                'key'   => 'Asia/Yakutsk',
                'value' => '(GMT+09:00) Yakutsk',
            ],
            [
                'key'   => 'Australia/Adelaide',
                'value' => '(GMT+09:30) Adelaide',
            ],
            [
                'key'   => 'Australia/Darwin',
                'value' => '(GMT+09:30) Darwin',
            ],
            [
                'key'   => 'Australia/Brisbane',
                'value' => '(GMT+10:00) Brisbane',
            ],
            [
                'key'   => 'Australia/Hobart',
                'value' => '(GMT+10:00) Hobart',
            ],
            [
                'key'   => 'Asia/Vladivostok',
                'value' => '(GMT+10:00) Vladivostok',
            ],
            [
                'key'   => 'Australia/Lord_Howe',
                'value' => '(GMT+10:30) Lord Howe Island',
            ],
            [
                'key'   => 'Asia/Magadan',
                'value' => '(GMT+11:00) Magadan',
            ],
            [
                'key'   => 'Pacific/Norfolk',
                'value' => '(GMT+11:30) Norfolk Island',
            ],
            [
                'key'   => 'Asia/Anadyr',
                'value' => '(GMT+12:00) Anadyr, Kamchatka',
            ],
            [
                'key'   => 'Pacific/Auckland',
                'value' => '(GMT+12:00) Auckland, Wellington',
            ],
            [
                'key'   => 'Pacific/Tongatapu',
                'value' => '(GMT+13:00) Nuku’alofa',
            ],
        ];
        return response()
            ->json($list)
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getTimezoneWithOffset()


}//end class
