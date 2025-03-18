<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Helpers\MediaEntityHelper;
use App\Models\MediaEntity\MediaEntity;
use App\Http\Controllers\Base\BaseUpdate;
use App\Http\Resources\MediaEntityResource;
use App\Http\Requests\MediaEntity\MediaEntityUpdateRequest;

/**
 * Class MediaEntityUpdate
 *
 * @extends  BaseUpdate BaseUpdate
 * @category Controllers
 * @package  App\Http\Controllers\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityUpdate extends BaseUpdate
{

    /**
     * @var string
     */
    public string $modelClass = MediaEntity::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaEntityResource::class;

    /**
     * @var string
     */
    public string $requestClass = MediaEntityUpdateRequest::class;


    /**
     * Set Entity Request Data
     *
     * @return void
     */
    public function setEntityRequestData(): void
    {
        $this->entityRequestData = $this->request->validated();
        $this->entityRequestData['entityType'] = MediaEntityHelper::getEntityTypeClass($this->entityRequestData['entityType']);

    }//end setEntityRequestData()


    /**
     * Apply Query
     *
     * @param  mixed $itemId
     * @return void
     */
    public function executeUpdateQuery($itemId): void
    {
        $this->model->where('id', $itemId)->update($this->entityRequestData);
        $this->item = $this->model->with($this->request->input('includes', []))->find($itemId);

    }//end executeUpdateQuery()


}//end class
