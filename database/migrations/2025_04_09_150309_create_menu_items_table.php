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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->index('idx_menu_items_category_id');
            $table->string('item_name', 100);
            $table->string('slug', 100)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10);
            $table->string('image', 100);
            $table->boolean('is_hidden')->default(false);
            $table->string('language', 10)->default('en');
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
            $table->integer('restaurant_id')->index('fk_menu_items_restaurant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
};
