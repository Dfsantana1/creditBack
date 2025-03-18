<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseDetail
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class BaseDetail extends Controller
{

    /**
     * @var Model
     */
    public Model $model;

    /**
     * @var Container
     */
    public Container $container;

    /**
     * @var mixed
     */
    public mixed $item;

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
    public string $requestClass = Request::class;

    /**
     * @var Request
     */
    public Request $request;


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
     * Show
     *
     * @param  mixed $itemId
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function show(mixed $itemId): JsonResponse
    {
        $this->initialise();
        $this->applyShowQuery($itemId);
        return $this->getResourceCollection($this->item);

    }//end show()


    /**
     * ApplyQuery
     *
     * @param  mixed $itemId
     * @return void
     */
    public function applyShowQuery(mixed $itemId): void
    {
        $this->item = $this->model->with($this->request->input('includes', []))->findOrFail($itemId);

    }//end applyShowQuery()


    /**
     * Resource Collection
     *
     * @param  $item
     * @return JsonResponse
     */
    public function getResourceCollection($item): JsonResponse
    {
        return response()
            ->json($this->resourceClass::make($item))
            ->setStatusCode(Response::HTTP_OK);

    }//end getResourceCollection()


}//end class
