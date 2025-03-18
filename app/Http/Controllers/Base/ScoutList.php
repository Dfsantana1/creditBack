<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

/**
 * Class ScoutList
 *
 * @extends  BaseList BaseList
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class ScoutList extends BaseList
{


    /**
     * @return mixed
     */
    public function initialiseQuery(): mixed
    {
        if ($this->request->input('filters.withTrashed') || $this->request->boolean('filters.archivedInd.0')) {
            return $this->model::search($this->request->input('q', null))->withTrashed();
        }

        return $this->model::search($this->request->input('q', null));

    }//end initialiseQuery()


    /**
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function list(): JsonResponse
    {
        if (request()->input('page', null)) {
            return $this->paginatedList();
        }

        $this->isPaginated = false;

        return parent::list();

    }//end list()


}//end class
