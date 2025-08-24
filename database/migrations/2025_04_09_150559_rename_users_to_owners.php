<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUsersToOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Drop all foreign keys referencing users
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('order_on', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('order_off', function (Blueprint $table) {
            $table->dropForeign(['chef_id']);
        });

        // 2. Rename the table
        Schema::rename('users', 'owners');

       // 3. Recreate foreign keys to the new 'owners' table
          Schema::table('orders', function (Blueprint $table) {
              $table->foreign('user_id')->references('id')->on('owners')->onDelete('cascade');
          });
  
          Schema::table('restaurants', function (Blueprint $table) {
              $table->foreign('user_id')->references('id')->on('owners')->onDelete('cascade');
          });
  
          Schema::table('order_on', function (Blueprint $table) {
              $table->foreign('user_id')->references('id')->on('owners')->onDelete('cascade');
          });
  
          Schema::table('order_off', function (Blueprint $table) {
              $table->foreign('chef_id')->references('id')->on('owners')->onDelete('cascade');
          });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('owners', function (Blueprint $table) {
            //
        });
    }
}
