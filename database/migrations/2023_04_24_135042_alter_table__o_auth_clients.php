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
    public function up()
    {
        Schema::table(
            'OAuthClients',
            function (Blueprint $table) {
                $table->uuid('entityId')
                    ->nullable()
                    ->comment('Use for morph relation if needed')
                    ->after('provider');
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
            'OAuthClients',
            function (Blueprint $table) {
                $table->dropColumn('entityId');
            }
        );

    }//end down()


};
