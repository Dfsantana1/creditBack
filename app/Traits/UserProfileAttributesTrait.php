<?php
declare(strict_types=1);

namespace App\Traits;


/**
 * Class UserProfileAttributesTrait
 *
 * @category Traits
 * @package  App\Traits
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
trait UserProfileAttributesTrait
{


    /**
     * Get full name attribute
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->profile?->firstName." ".$this->profile?->lastName;

    }//end getFullNameAttribute()


}
