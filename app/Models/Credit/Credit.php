<?php

namespace App\Models\Credit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Quota\Quota;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Credit extends Model
{
    use HasFactory, SoftDeletes,UuidTrait,Searchable;
    protected $primaryKey = 'id';


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

    protected $table = 'credits'; // Nombre de la tabla


    protected $guarded = [];


    protected $dates = ['deletedAt'];

    // Relación con cuotas (una crédito tiene muchas cuotas)
    public function quotas(): HasMany
    {
        return $this->hasMany(Quota::class, 'creditId', 'id')->orderBy('dueDate');
    }
    
    public function isPaid(): bool
    {
        return $this->quotas()->where('status', '!=', 'Pagado')->doesntExist();
    }
}
