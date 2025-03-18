<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Enums\MediaEntityEnum;
use App\Helpers\MediaEntityHelper;
use App\Http\Controllers\Base\BaseCreate;
use App\Http\Requests\MediaEntity\MediaEntityUpdateRequest;
use App\Http\Resources\MediaEntityResource;
use App\Models\MediaEntity\MediaEntity;

/**
 * Class MediaEntityCreate
 *
 * @extends  BaseCreate BaseCreate
 * @category Controllers
 * @package  App\Http\Controllers\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityCreate extends BaseCreate
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
     * Execute InsightCreate Query
     *
     * @return void
     */
    public function executeCreateQuery(): void
    {
        $this->mediaEntity = $this->model->create($this->entityRequestData);
        $this->item        = $this->model->with($this->request->input('includes', []))->find($this->mediaEntity->id);

    }//end executeCreateQuery()


}//end class
