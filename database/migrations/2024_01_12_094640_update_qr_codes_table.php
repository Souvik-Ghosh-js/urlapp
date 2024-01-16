<?php

// database/migrations/xxxx_xx_xx_update_qr_codes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQrCodesTable extends Migration
{
    public function up()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('visit_count')->default(0)->after('qr_code');
        });
    }

    public function down()
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropColumn('visit_count');
        });
    }
}
