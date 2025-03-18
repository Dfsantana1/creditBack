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
        Schema::create('quotas', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relación con créditos
            $table->uuid('creditId');
            $table->foreign('creditId')
                ->references('id')
                ->on('credits')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Monto de la cuota
            $table->decimal('amount', 10, 2);

            // Fecha de vencimiento
            $table->date('dueDate');

     
            $table->enum('status', ['Pendiente', 'Pagado'])->default('Pendiente');

            // Timestamps
            $table->timestamp('updatedAt')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('deletedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotas');
    }
};
