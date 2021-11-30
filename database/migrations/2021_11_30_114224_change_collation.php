<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCollation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->text('long_url')->collation('utf8mb4_bin')->change();
            $table->string('short_url')->collation('utf8mb4_bin')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
        $table->text('long_url')->collation('utf8mb4_unicode_ci')->change();
        $table->string('short_url')->collation('utf8mb4_unicode_ci')->change();
        });
    }
}
