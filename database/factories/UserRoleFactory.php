<?php

namespace Database\Factories;

use App\Models\User\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\User\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UserRoleFactory
 *
 * @extends  Factory factory
 * @category Factories
 * @package  Database\Factories

 */
class UserRoleFactory extends Factory
{

    /**
     * The name of the factory's corresponding product.
     *
     * @var string
     */
    protected $model = UserRole::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'id' => Str::uuid(),
            'userId' => User::query()->inRandomOrder()->first(),
            'roleId' => Role::query()->inRandomOrder()->first(),
        ];

    }//end definition()


}//end class
