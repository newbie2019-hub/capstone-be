<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgUnitRoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_unit_role_users', function (Blueprint $table) {
            $table->foreignId('user_account_id')->constrained()->onDelete('cascade');
            $table->foreignId('org_unit_role_id')->constrained()->onDelete('cascade');
            $table->foreignId('org_unit_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_unit_role_users');
    }
}
