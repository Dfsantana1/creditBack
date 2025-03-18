<?php

namespace App\Models\Quota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Credit\Credit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UuidTrait;

class Quota extends Model
{
    use HasFactory, SoftDeletes,UuidTrait;

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

    protected $table = 'quotas'; // Nombre de la tabla

    protected $fillable = [
        'creditId',
        'amount',
        'dueDate',
        'status',
        'createdAt',
        'updatedAt',
        'deletedAt',
    ];

    protected $dates = ['deletedAt'];

    // Relación con crédito (cada cuota pertenece a un crédito)
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'creditId', 'id');
    }
}
