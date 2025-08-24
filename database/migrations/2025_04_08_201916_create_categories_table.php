<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // assumes users table
            $table->string('category_name', 100);
            $table->string('language', 10)->default('en');
            $table->timestamps(); // handles created_at and updated_at

            $table->foreign('user_id')
      ->references('id')
      ->on('owners')
      ->onDelete('cascade')
      ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
