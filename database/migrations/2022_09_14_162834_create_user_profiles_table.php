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
            'userProfiles',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('firstName');
                $table->string('preferredName')->nullable();
                $table->string('lastName');
                $table->date('birthdate')->nullable();
                $table->string('nickname')->nullable();
                $table->string('urlSlug')->nullable();
                $table->string('emailStatus')->nullable();
                $table->string('phoneNumber')->nullable();
                $table->string('gender')->nullable();
                $table->integer('views')->nullable();
                $table->text('about')->nullable();

                $table->uuid('mediaId')->nullable();
                $table->foreign('mediaId')
                    ->references('id')
                    ->on('media')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->uuid('userId');
                $table->foreign('userId')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->timestamp('archivedAt')->nullable();
                $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('createdAt')->useCurrent();
                $table->timestamp('deletedAt')->nullable();

                $table->unique(
                    ['userId'],
                    'UniqueUserProfile'
                );
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
        Schema::dropIfExists('userProfiles');

    }//end down()


};
