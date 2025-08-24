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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 50)->unique('idx_users_username');
            $table->string('email', 100)->nullable()->unique('idx_users_email');
            $table->string('password');
            $table->boolean('verified')->default(false)->comment('FALSE=Not Verified, TRUE=Verified');
            $table->string('email_verification_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->dateTime('reset_token_expires_at')->nullable();
            $table->string('code', 50)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->string('remember_token')->nullable();
            $table->date('date_of_birth');
            $table->enum('sex', ['male', 'female']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
