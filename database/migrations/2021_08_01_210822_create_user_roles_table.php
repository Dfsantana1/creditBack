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
            'userRoles',
            function (Blueprint $table) {
                $table->uuid('id')->primary();

                $table->uuid('userId');
                $table->foreign('userId')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->uuid('roleId');
                $table->foreign('roleId')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->uuid('roleableId')->nullable();
                $table->string('roleableType')->nullable();

                $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('createdAt')->useCurrent();
                $table->timestamp('deletedAt')->nullable();

                $table->unique(
                    [
                        'roleableId',
                        'roleableType',
                        'userId',
                        'roleId',
                        'deletedAt',
                    ],
                    'UniqueRoleable'
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
        Schema::dropIfExists('userRoles');

    }//end down()


};
