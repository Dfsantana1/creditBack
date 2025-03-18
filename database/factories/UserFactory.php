<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class UserFactory
 *
 * @extends  Factory factory
 * @category Factories
 * @package  Database\Factories

 */
class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding product.
     *
     * @var string
     */
    protected $model = User::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'           => $this->faker->unique()->safeEmail(),
            'emailVerifiedAt' => now(),
            'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'rememberToken'   => Str::random(10),
        ];

    }//end definition()


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return UserFactory
     */
    public function unverified(): UserFactory
    {
        return $this->state(
            function (array $attributes) {
                return ['emailVerifiedAt' => null];
            }
        );

    }//end unverified()


}//end class
