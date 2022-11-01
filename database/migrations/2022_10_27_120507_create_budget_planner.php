<?php

use App\Http\Controllers\Auth\RegisterController;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->timestamp('verified_at')->nullable();
            $table->integer('verified_by')->nullable();
            $table->integer('role')->default(0);
            $table->string('department')->default("HR");
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('department');
            $table->string('description');
            $table->string('status');
            $table->string('equipment');
            $table->integer('approved');
            $table->decimal('amount_requested', 10, 2);
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('type');
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
