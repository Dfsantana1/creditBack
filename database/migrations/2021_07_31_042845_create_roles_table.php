<?php

use App\Enums\User\UserRoleEnum;
use App\Models\User\Role;
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
            'roles',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name', 25)->unique();
            }
        );

        foreach (UserRoleEnum::cases() as $role) {
            Role::query()->create(
                [
                    'name' => $role->name,
                ]
            );
        }

    }//end up()


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');

    }//end down()


};
