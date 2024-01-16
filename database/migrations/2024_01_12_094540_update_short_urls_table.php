<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateShortUrlsTable extends Migration
{
    public function up()
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->unsignedBigInteger('visit_count')->default(0)->after('short_url');
        });
    }

    public function down()
    {
        Schema::table('short_urls', function (Blueprint $table) {
            $table->dropColumn('visit_count');
        });
    }
}
