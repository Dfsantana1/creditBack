<?php
declare(strict_types=1);

namespace App\Http\Controllers\Base;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class BaseDelete
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Base
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
abstract class BaseDelete extends Controller
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
    public mixed $itemId;

    /**
     * @var string
     */
    public string $modelClass;

    /**
     * @var string
     */
    public string $deleteEntityName;


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
    public function initialise()
    {
        $this->model            = $this->container->make($this->modelClass);
        $this->deleteEntityName = (!empty($this->deleteEntityName) ? $this->deleteEntityName : class_basename($this->modelClass));

    }//end initialise()


    /**
     * Delete
     *
     * @param  mixed $itemId
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function delete(mixed $itemId): JsonResponse
    {
        $this->initialise();

        $this->applyDeleteQuery($itemId);

        return response()
            ->json(['message' => $this->deleteEntityName.' delete successfully.'])
            ->setStatusCode(Response::HTTP_OK);

    }//end delete()


    /**
     * ApplyQuery
     *
     * @param  mixed $itemId
     * @return void
     */
    public function applyDeleteQuery(mixed $itemId)
    {

        $data = $this->model->findOrFail($itemId);
        if (in_array('themes', request()->segments())) {
            $data->hideInd = true;
            $data->save();
        } else {
            $data->delete();
        }

    }//end applyDeleteQuery()


}//end class
