<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MediaSeeder;


/**
 * Class DatabaseSeeder
 *
 * @extends  Seeder factory
 * @category Seeders
 * @package  Database\Seeders

 */
class DatabaseSeeder extends Seeder
{


    /**
     * Run Seeder
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(
            [
                UserSeeder::class,
                MediaSeeder::class,
            ]
        );

    }//end run()


}//end class
