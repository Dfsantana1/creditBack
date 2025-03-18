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
        Schema::create(
            'mediaEntities',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('mediaId');
                $table->foreign('mediaId')
                    ->references('id')
                    ->on('media')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

                $table->uuid('entityId');
                $table->string('entityType');
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
        Schema::dropIfExists('mediaEntities');

    }//end down()


};
