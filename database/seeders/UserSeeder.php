<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\User\UserRoleEnum;
use App\Models\User\Role;
use App\Models\User;
use App\Models\User\UserProfile;
use App\Models\User\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSeeder
 *
 * @extends  Seeder factory
 * @category Seeders
 * @package  Database\Seeders

 */
class UserSeeder extends Seeder
{

    use WithoutModelEvents;


    /**
     * Run Seeder
     *
     * @return void
     */
    public function run(): void
    {
        $this->createAdmin();

    }//end run()


    /**
     * Create Admin User
     *
     * @return void
     */
    protected function createAdmin(): void
    {
        /**
         * @var \App\Models\User\User $admin
         */
        $admin = User::query()->firstOrCreate(
            [
				'id' => Str::uuid(),
                'email'    => 'admi@system.com',
                'password' => Hash::make('nMlkj.,768-Ab'),
            ]
        );
        /**
         * @var \App\Models\User\Role $role $role
         */
        $role = Role::query()->where('name', UserRoleEnum::ADMIN->name)->first();
        UserRole::query()->create(
			[
				'id'       => Str::uuid(),
				'userId'       => $admin->id,
				'roleId'       => $role->id,
			]
		);
        UserProfile::factory()->count(1)->create(
            [
				'id' => Str::uuid(),
                'userId'    => $admin->id,
                'firstName' => 'Admin',
                'lastName'  => 'System',
            ]
        );
    }//end createAdmin()

}//end class
