<?php

 // database/migrations/xxxx_xx_xx_update_masked_urls_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMaskedUrlsTable extends Migration
{
    public function up()
    {
        Schema::table('masked_urls', function (Blueprint $table) {
            $table->unsignedBigInteger('visit_count')->default(0)->after('masked_url');
        });
    }

    public function down()
    {
        Schema::table('masked_urls', function (Blueprint $table) {
            $table->dropColumn('visit_count');
        });
    }
}
