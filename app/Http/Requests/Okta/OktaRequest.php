<?php

namespace App\Http\Requests\Okta;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class OktaRequest
 *
 * @category Request
 * @package  App\Http\Requests\Okta
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class OktaRequest extends FormRequest
{


    /**
     * @param  array $attributes
     * @return bool
     */
    public function check(array $attributes): bool
    {
        $valid    = false;
        $required = [
            'first_name',
            'last_name',
            'email',
            'corporation_id',
            'user_role',
            'brookdale_communities_ids',
        ];

        if (count(array_intersect_key(array_flip($required), $attributes)) === count($required)) {
            $valid = true;
        }

        return $valid;

    }//end check()


}//end class
