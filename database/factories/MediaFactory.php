<?php

namespace Database\Factories;

use App\Models\Media\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class MediaFactory
 *
 * @extends  Factory factory
 * @category Factories
 * @package  Database\Factories

 */
class MediaFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $imageUrl = $this->faker->imageUrl();
        $fileName = basename($imageUrl);
        $pattern  = "/\d{3}/i";
        preg_match_all($pattern, $imageUrl, $matches);
        return [
            'name'           => $fileName,
            'description'    => $this->faker->text(50),
            'fileType'       => 'image/png',
            'type'           => 'image',
            'extension'      => 'png',
			'documentId'      => 'yiuwsidjiewjoisa',
            'width'          => (!empty($matches[0][0])) ? $matches[0][0] : null,
            'height'         => (!empty($matches[0][1])) ? $matches[0][1] : null,
            'bucketName'     => '',
            'resource'       => '',
            'url'            => $imageUrl,
            'uploadByUserId' => User::query()->inRandomOrder()->first(),
            'mediableId'     => 1,
            'mediableType'   => 1,
        ];

    }//end definition()


}//end class
