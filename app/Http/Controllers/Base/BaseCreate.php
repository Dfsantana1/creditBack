<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseCreate
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class BaseCreate extends Controller
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
    public string $requestClass;

    /**
     * @var array
     */
    public array $entityRequestData;


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
     * Set Entity Request Data
     *
     * @return void
     */
    public function setEntityRequestData(): void
    {
        $this->entityRequestData = $this->request->validated();

    }//end setEntityRequestData()


    /**
     * InsightCreate Item
     *
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function create(): JsonResponse
    {
        $this->initialise();
        $this->setEntityRequestData();
        $this->modifyRequest();
        $this->executeCreateQuery();
        $this->executeSecondaryProcess();

        return $this->getResource($this->item);

    }//end create()


    /**
     * Execute InsightCreate Query
     *
     * @return void
     */
    public function executeCreateQuery(): void
    {
        $this->item = $this->model->create($this->entityRequestData);

    }//end executeCreateQuery()


    /**
     * Resource
     *
     * @param  $item
     * @return JsonResponse
     */
    public function getResource($item): JsonResponse
    {
        return response()
            ->json($this->resourceClass::make($item))
            ->setStatusCode(Response::HTTP_OK);

    }//end getResource()


    /**
     * Execute Secondary Process
     *
     * @return void
     */
    public function executeSecondaryProcess(): void
    {

    }//end executeSecondaryProcess()


    /**
     * Modify Request
     *
     * @return void
     */
    public function modifyRequest(): void
    {

    }//end modifyRequest()


}//end class
