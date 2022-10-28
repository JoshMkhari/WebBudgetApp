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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->nullable();
            $table->integer('role');
            $table->string('department');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->string('description');
            $table->string('status');
            $table->decimal('amount_requested', 10, 2);
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('budget_planner');
    }
};
