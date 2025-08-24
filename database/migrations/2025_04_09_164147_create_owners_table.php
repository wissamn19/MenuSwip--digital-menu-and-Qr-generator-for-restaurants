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
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullName', 50)->unique('idx_owners_fullName');
            $table->string('Email', 100)->nullable()->unique('idx_owners_Email');
            $table->string('password');
            $table->boolean('verified')->default(false)->comment('FALSE=Not Verified, TRUE=Verified');
            $table->string('email_verification_token')->nullable();
            $table->string('reset_token')->nullable();
            $table->dateTime('reset_token_expires_at')->nullable();
            $table->string('code', 50)->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->string('remember_token')->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->string('phonen', 20)->collation('utf8mb4_general_ci')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('owners');
    }
};
