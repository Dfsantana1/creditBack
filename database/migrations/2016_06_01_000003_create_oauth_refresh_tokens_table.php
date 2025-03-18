<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'OAuthRefreshTokens',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('access_token_id', 100)->index();
                $table->boolean('revoked');
                $table->dateTime('expires_at')->nullable();
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
        Schema::dropIfExists('OAuthRefreshTokens');

    }//end down()


};
