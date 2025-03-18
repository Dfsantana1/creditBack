<?php
declare(strict_types=1);

namespace App\Models\Location;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * Investor Class
 *
 * @category Category
 * @package  App\Models
 * @property string $id
 * @property string $name
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Carbon $deletedAt
 * @method   static find(string $locationId)

 */
class Location extends Model
{
    use UuidTrait, Searchable, SoftDeletes, HasFactory;

    /**
     * @var string Rename created_at
     */
    const CREATED_AT = 'createdAt';
    /**
     * @var string Rename updated_at
     */
    const UPDATED_AT = 'updatedAt';
    /**
     * @var string Rename deleted_at
     */
    const DELETED_AT = 'deletedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $casts = ['googleResponseJson' => 'array'];


}//end class
