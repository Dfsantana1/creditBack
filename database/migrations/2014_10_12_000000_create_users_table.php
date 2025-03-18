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
            'users',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('email')->unique();
                $table->timestamp('emailVerifiedAt')->nullable();
                $table->dateTime('emailConfirmedAt')->nullable();
                $table->string('password');
                $table->string('rememberToken')->nullable();
				$table->string('socialiteProvider')->nullable();
				$table->string('socialiteId')->nullable();
				$table->text('oAuthToken')->nullable();
				$table->float('apiBalanceValue')->nullable();
                $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('createdAt')->useCurrent();
                $table->timestamp('deletedAt')->nullable();
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
        Schema::dropIfExists('users');

    }//end down()


};
