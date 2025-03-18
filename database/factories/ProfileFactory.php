<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ProfileFactory
 *
 * @extends  Factory factory
 * @category Factories
 * @package  Database\Factories

 */
class ProfileFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'          => User::query()->inRandomOrder()->first(),
            'first_name'       => $this->faker->firstName(),
            'last_name'        => $this->faker->lastName(),
            'code'             => $this->faker->randomKey(),
            'nickname'         => $this->faker->userName,
            'url_slug'         => $this->faker->slug,
        ];

    }//end definition()


}//end class
