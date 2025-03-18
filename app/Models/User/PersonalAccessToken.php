<?php
declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * Class PersonalAccessToken
 *
 * @category Auth
 * @package  App\Models

 */
class PersonalAccessToken extends SanctumPersonalAccessToken
{

    use SoftDeletes;

    /**
     * Rename Default Name Table
     *
     * @var string
     */
    protected $table = 'personalAccessTokens';

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

}//end class
