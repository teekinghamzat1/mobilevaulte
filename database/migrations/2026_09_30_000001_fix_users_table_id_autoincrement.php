<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixUsersTableIdAutoincrement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if id is already a key or if a primary key exists
        $primaryKeys = DB::select("SHOW KEYS FROM `users` WHERE Key_name = 'PRIMARY'");
        if (empty($primaryKeys)) {
            DB::statement('ALTER TABLE `users` ADD PRIMARY KEY (`id`)');
        }

        // Modify the id column of the users table so that it is AUTO_INCREMENT
        DB::statement('ALTER TABLE `users` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No change needed on rollback
    }
}
