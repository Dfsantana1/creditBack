<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\QueryFilters\Pagination;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseList
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class BaseList extends Controller
{

    /**
     * @var Model
     */
    public Model $model;

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var Container
     */
    public Container $container;

    /**
     * @var LengthAwarePaginator
     */
    public LengthAwarePaginator $paginatedItems;

    /**
     * @var mixed
     */
    public mixed $items;

    /**
     * @var string
     */
    public string $resourceClass;

    /**
     * @var string
     */
    public string $modelClass;

    /**
     * @var string
     */
    public string $requestClass;

    /**
     * @var boolean
     */
    public bool $isPaginated = true;

    /**
     * @var array $filters
     */
    public array $filters = [];


    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

    }//end __construct()


    /**
     * Initialise Classes
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function initialise(): void
    {
        $this->model   = $this->container->make($this->modelClass);
        $this->request = $this->container->make($this->requestClass);

    }//end initialise()


    /**
     * @return mixed
     */
    abstract public function initialiseQuery(): mixed;


    //end initialiseQuery()


    /**
     * Paginated List of Items
     *
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function paginatedList(): JsonResponse
    {
        $this->initialise();
        $this->applyPaginatedQuery();

        return $this->getResourceCollection($this->paginatedItems);

    }//end paginatedList()


    /**
     * List of Items
     *
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function list(): JsonResponse
    {
        $this->initialise();
        $this->applyQuery();

        return $this->getResourceCollection($this->items);

    }//end list()


    /**
     * Apply Paginated Query
     *
     * @return void
     */
    public function applyPaginatedQuery(): void
    {
        $this->paginatedItems = $this->initialiseQuery()
            ->query($this->applyPipeLine())
            ->paginate($this->request->input('limit', 15));

    }//end applyPaginatedQuery()


    /**
     * Apply Query
     *
     * @return void
     */
    public function applyQuery(): void
    {
        $this->items = $this->initialiseQuery()->get();

    }//end applyQuery()


    /**
     * Resource Collection
     *
     * @param  $items
     * @return JsonResponse
     */
    public function getResourceCollection($items): JsonResponse
    {
        return $this->resourceClass::collection($items)
            ->toResponse($this->request)
            ->setStatusCode(Response::HTTP_OK);

    }//end getResourceCollection()


    /**
     * Apply Through Items
     *
     * @return string[]
     */
    public function applyThroughItems(): array
    {
        if (!$this->isPaginated) {
            return [];
        }

        if (empty($this->filters)) {
            return [
                Pagination::class,
            ];
        }

        return $this->filters;

    }//end applyThroughItems()


    /**
     * Apply PipeLine
     *
     * @return Closure
     */
    public function applyPipeLine(): Closure
    {
        return function ($query) {
            app(Pipeline::class)
                ->send($query)
                ->through($this->applyThroughItems())
                ->thenReturn();
            $query->with($this->request->input('includes', []));
        };

    }//end applyPipeLine()


}//end class
