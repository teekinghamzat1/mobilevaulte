<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'currency')) {
                $table->string('currency', 10)->nullable()->after('account_bal');
            }
            if (!Schema::hasColumn('users', 's_currency')) {
                $table->string('s_currency', 10)->nullable()->after('currency');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $drop = [];
            if (Schema::hasColumn('users', 'currency')) {
                $drop[] = 'currency';
            }
            if (Schema::hasColumn('users', 's_currency')) {
                $drop[] = 's_currency';
            }
            if (!empty($drop)) {
                $table->dropColumn($drop);
            }
        });
    }
}
