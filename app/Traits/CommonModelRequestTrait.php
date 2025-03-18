<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Validation\ValidationException;

/**
 * Class CommonModelRequestTrait
 *
 * @category Request
 * @package  App\Traits

 */
trait CommonModelRequestTrait
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws ValidationException
     */
    public function getModelRequestRule(): array
    {
        $validModels    = collect([]);
        $nameValidation = '';
        $ruleValidation = [];
        $segments       = collect(request()->segments());
        $intersect      = strtoupper($validModels->intersect($segments)->first());
        if (empty($intersect)) {
            throw ValidationException::withMessages(['Entity' => 'Missing Value Id']);
        }

        switch ($intersect) {
        }//end switch

        return [
            'name'   => $nameValidation,
            'rule'   => $ruleValidation,
            'entity' => $intersect,
        ];

    }//end getModelRequestRule()


}//end class
