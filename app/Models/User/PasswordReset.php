<?php
declare(strict_types=1);

namespace App\Models\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 *
 * @category InterestDimension
 * @package  App\Models
 * @property string $email
 * @property string $token
 * @property Carbon $createdAt

 */
class PasswordReset extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Rename Default Table Name
     *
     * @var string
     */
    protected $table = 'passwordResets';

    /**
     * No User Timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

}//end class
