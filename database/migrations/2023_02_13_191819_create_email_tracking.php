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
            'emailTracking',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('emailId');
                $table->string('sender');
                $table->string('receiver');
                $table->uuid('userId')->nullable();
                $table->foreign('userId')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
                $table->text('body');
                $table->string('status');
                $table->json('detail')->nullable();
                $table->boolean('active')->default(true);
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
    public function down()
    {
        Schema::dropIfExists('emailTracking');

    }//end down()


};
