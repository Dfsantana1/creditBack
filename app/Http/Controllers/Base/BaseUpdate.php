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
 * Class BaseUpdate
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class BaseUpdate extends Controller
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
     * @var array
     */
    public array $updateFields;


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
        if (!empty($this->updateFields)) {
            $this->entityRequestData = $this->request->only($this->updateFields);
        } else {
            $this->entityRequestData = $this->request->validated();
        }

    }//end setEntityRequestData()


    /**
     * Update Item
     *
     * @param  mixed $itemId
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function update(mixed $itemId): JsonResponse
    {
        $this->initialise();
        $this->setEntityRequestData();
        $this->executeUpdateQuery($itemId);
        $this->executeSecondaryProcess();

        return $this->getResourceCollection($this->item);

    }//end update()


    /**
     * Apply Query
     *
     * @param  mixed $itemId
     * @return void
     */
    public function executeUpdateQuery(mixed $itemId): void
    {
        $this->model->where('id', $itemId)->update($this->entityRequestData);
        $this->item = $this->model->where('id', $itemId)->find($itemId);

    }//end executeUpdateQuery()


    /**
     * @param  mixed $item
     * @return JsonResponse
     */
    public function getResourceCollection(mixed $item): JsonResponse
    {
        if (empty($item)) {
            return response()
                ->json(['error' => 'Record not found.'])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return response()
            ->json($this->resourceClass::make($item))
            ->setStatusCode(Response::HTTP_OK);

    }//end getResourceCollection()


    /**
     * Execute Secondary Process
     *
     * @return void
     */
    public function executeSecondaryProcess(): void
    {

    }//end executeSecondaryProcess()


}//end class
