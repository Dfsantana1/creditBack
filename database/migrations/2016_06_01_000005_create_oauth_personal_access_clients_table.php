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
        Schema::create(
            'OAuthPersonalAccessClients',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->uuid('client_id');
                $table->timestamps();
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
        Schema::dropIfExists('OAuthPersonalAccessClients');

    }//end down()


};
