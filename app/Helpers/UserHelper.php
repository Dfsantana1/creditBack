<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Enums\User\UserHashEnum;
use App\Models\User;
use App\Models\User\UserProfile;
use Hashids\Hashids;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class UserHelper
 *
 * @category Helpers
 * @package  App\Helpers

 */
class UserHelper
{


    /**
     * Create Unique Email (Users Table)
     *
     * @param  array $data
     * @return string
     */
    public static function createUniqueEmail(array $data): string
    {
        do {
            $firstName    = preg_replace('/[^a-z]/', '', $data['firstName']);
            $firstLetter  = substr($firstName, 0, 1);
            $randomNumber = rand(0, 999);
            $lastName     = preg_replace('/[^a-z]/', '', $data['lastName']);
            $email        = strtolower($firstLetter).'.'.$lastName.'.'.$randomNumber.'@tsolife.com';
        } while (!empty(User::query()->where('email', $email)->first()));

        return $email;

    }//end createUniqueEmail()


    /**
     * Encode numbers, string treated as number, or array of number
     *
     * @param  int|string $oldUserId
     * @return string
     */
    public static function hashUserId(int|string $oldUserId): string
    {
        $hashids = new Hashids();
        #constants where used in v1 and should be included to make
        return $hashids->encode($oldUserId, UserHashEnum::INITIAL->value, UserHashEnum::LAST->value);

    }//end hashUserId()


    /**
     * Decode hash
     *
     * @param  string $hash
     * @return int|array
     */
    public static function decodeUserId(string $hash): int|array
    {
        $hashids = new Hashids();
        return $hashids->decode($hash);

    }//end decodeUserId()


    /**
     * Generate unique user slug by firstName and lastName
     *
     * @param  string|null $firstName
     * @param  string|null $lastName
     * @return string
     */
    public static function createUniqueUserSlug(string|null $firstName, string|null $lastName): string
    {
        $diff = "";
        if (empty($firstName) && empty($lastName)) {
            $firstName = fake()->firstName;
            $lastName  = fake()->lastName;
        }

        do {
            $slug = Str::slug($firstName.' '.$lastName.$diff);
            $diff = " ".rand(1000, 10000);
        } while (UserProfile::where('urlSlug', $slug)->count() > 0);

        return $slug;

    }//end createUniqueUserSlug()

}//end class
