<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(
            'emailTracking',
            function (Blueprint $table) {
                $table->string('type')
                    ->nullable()
                    ->default(\App\Enums\EmailTrackingTypes::TRANSACTIONAL->value)
                    ->after('detail');
            }
        );

    }//end up()


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'emailTracking',
            function (Blueprint $table) {
                $table->dropColumn('type');
            }
        );

    }//end down()


};
