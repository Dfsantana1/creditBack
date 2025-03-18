<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Media\Media;
use Illuminate\Database\Seeder;

/**
 * Class MediaSeeder
 *
 * @extends  Seeder factory
 * @category Seeders
 * @package  Database\Seeders

 */
class MediaSeeder extends Seeder
{


    /**
     * Run Seeder
     *
     * @return void
     */
    public function run(): void
    {
        Media::factory(10)->create();

    }//end run()


}//end class
