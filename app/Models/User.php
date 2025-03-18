<?php
declare(strict_types=1);

namespace App\Models;
use App\Models\Tenant;
use App\Models\ModelBot;
use App\Models\ApiFolder;
use App\Models\User\Role;
use App\Traits\UuidTrait;
use App\Models\ApiService;
use App\Models\Media\Media;
use Illuminate\Http\Request;
use Laravel\Cashier\Billable;
use Laravel\Scout\Searchable;
use App\Models\ProductComment;
use Illuminate\Support\Carbon;
use App\Models\PlanSubscription;
use App\Models\User\UserProfile;
use App\Models\Location\Location;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ApiServiceRecharge;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Database\Factories\UserFactory;
use App\Models\Form\FormFieldsetGroup;
use App\Models\Corporation\Corporation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form\FormFieldsetGroupResponse;
use App\Models\SubscribeNotificationsRealtime;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Class User
 *
 * @category      User
 * @package       App\Models
 * @property      int $id
 * @property      string $email
 * @property      string $password
 * @property      int $oldUserId
 * @property      Carbon $emailConfirmedAt
 * @property      Carbon $createdAt
 * @property      Carbon $updatedAt
 * @property-read UserProfile $profile
 * @property-read Collection|FormFieldsetGroupResponse[] $formFieldsetGroupResponses
 * @property-read Collection|Corporation[] $corporations
 * @property-read Collection|FormFieldsetGroup[] $formFieldsetGroups
 * @method        ofMoveIn(int $movedInDaysAgo)
 * @method        ofBirthday(Carbon $startDt, Carbon $endDt)
 * @method        static find(string $userId)
 * @author        Mauricio Tovar <tmauricio80@gmail.com>
 * @license       https://opensource.org/licenses/MIT MIT License
 * @link          
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait, Searchable, SoftDeletes, Billable;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['emailVerifiedAt' => 'datetime'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'profile',
        'profile.media',
        'roles',
    ];


    /**
     * Rename Remember Token
     *
     * @return string
     */
    public function getRememberTokenName(): string
    {
        return 'rememberToken';

    }//end getRememberTokenName()


    /**
     * User Factory
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();

    }//end newFactory()
    

    //------------------------------------------------------
    // FUNCTIONS
    //------------------------------------------------------


    /**
     * Get User Roles Array
     *
     * @return array
     */
    public function rolesArray(): array
    {
        return $this->roles()->pluck('name')->toArray();

    }//end rolesArray()


    //------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------


    /**
     * Get User Roles
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'userRoles', 'userId', 'roleId')
            // ->leftJoin('companies', 'companies.id', 'userRoles.roleableId')
            // ->leftJoin('tenants', 'tenants.id', 'userRoles.roleableId')
			// ->leftJoin('modelBots', 'modelBots.id', 'userRoles.roleableId')
            // ->selectRaw('roles.id, roles.name, tenants.id as tenantId, tenants.name as tenantName, companies.id as companyId, companies.name as companyName, modelBots.id as modelBotId, modelBots.name as modelBotName')
            ->whereNull('userRoles.deletedAt');

    }//end roles()


    /**
     * Get User Profile
     *
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'userId');

    }//end profile()


    /**
     * Get Media
     *
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable', 'mediableType', 'mediableId');

    }//end image()


	/**
     * Get all user Media
     *
     * @return HasMany
     */
	public function medias(): HasMany
    {
        return $this->hasMany(Media::class, 'uploadByUserId');
    }


    /**
     * Get Locations
     *
     * @return HasMany
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'locationableId');

    }//end locations()


}//end class
