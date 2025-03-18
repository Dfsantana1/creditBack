<?php

namespace Database\Factories;

use App\Enums\User\UserEmailStatusEnum;
use App\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * Class UserProfileFactory
 *
 * @extends  Factory factory
 * @category Factories
 * @package  Database\Factories

 */
class UserProfileFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName'     => $this->faker->firstName(),
            'lastName'      => $this->faker->lastName(),
            'preferredName' => $this->faker->firstName(),
            'nickname'      => $this->faker->userName(),
            'urlSlug'       => Str::random(10),
            'emailStatus'   => UserEmailStatusEnum::UNKNOWN->name,
            'gender'        => 'MALE',
        ];

    }//end definition()


}//end class
