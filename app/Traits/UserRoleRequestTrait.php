<?php
declare(strict_types=1);

namespace App\Traits;

use App\Enums\User\UserRoleEnum;
use Illuminate\Support\Str;

/**
 * Class UserRoleRequestTrait
 *
 * @category Request
 * @package  App\Traits

 */
trait UserRoleRequestTrait
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function getUserRoleByRequest(): array
    {
        $validModels = collect(['corporations', 'themes']);
        $segments    = collect(request()->segments());
        $intersect   = Str::singular(strtoupper($validModels->intersect($segments)->first()));
        return collect(UserRoleEnum::cases())->filter(
            function ($value) use ($intersect) {
                return Str::startsWith($value->value, $intersect);
            }
        )
        ->pluck('name')
        ->toArray();

    }//end getUserRoleByRequest()


}//end class
