<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * Class UuidTrait
 *
 * @category Request
 * @package  App\Traits

 */
trait UuidTrait
{


    /**
     *  Boot function from Laravel.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(
            function ($model) {
                if (empty($model->{$model->getKeyName()})) {
                    $model->{$model->getKeyName()} = Str::uuid()->toString();
                }
            }
        );

    }//end boot()


    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;

    }//end getIncrementing()


    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';

    }//end getKeyType()


}
