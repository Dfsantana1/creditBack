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
            'media',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('description')->nullable();
                $table->string('fileType');
                $table->string('type');
                $table->string('extension', 10);
                $table->string('size')->nullable();
                $table->integer('width')->nullable();
                $table->integer('height')->nullable();
				$table->decimal('bytesSize')->nullable();
				$table->string('documentId')->nullable(); //vectorial database
                $table->string('source')->nullable();

                $table->string('bucketName');
                $table->string('resource');
                $table->string('url');

                $table->uuid('mediableId')->nullable();
                $table->string('mediableType')->nullable();

                $table->uuid('uploadByUserId')->nullable();
                $table->foreign('uploadByUserId')
                    ->references('id')
                    ->on('users')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

				$table->date('wasNotifyingDate')->nullable();

                $table->timestamp('archivedInGalleyAt')->nullable();
                $table->timestamp('dueAt')->nullable();
                $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('createdAt')->useCurrent();
                $table->timestamp('deletedAt')->nullable();
            }
        );

        Schema::table(
            'media',
            function (Blueprint $table) {
                $table->uuid('parentId')
                    ->nullable()
                    ->after('description');
                $table->foreign('parentId')
                    ->references('id')
                    ->on('media')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
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
        Schema::dropIfExists('media');

    }//end down()


};
