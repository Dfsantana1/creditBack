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
            'legacyMigrations',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('originTableName');
                $table->string('destinationTableName');
                $table->integer('originId');
                $table->text('destinationId')->nullable();
                $table->longText('content');
                $table->string('state');
                $table->longText('details')->nullable();
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
        Schema::dropIfExists('legacyMigrations');

    }//end down()


};
