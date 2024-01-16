<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Remove columns from urls table
        Schema::table('urls', function (Blueprint $table) {
            $table->dropColumn('short_url');
            $table->dropColumn('masked_url');
            $table->dropColumn('qr_code');
            $table->dropColumn('visit_count');
        });
    }

    public function down()
    {
        // Add columns back to urls table if needed (adjust as necessary)
        Schema::table('urls', function (Blueprint $table) {
            $table->string('short_url')->nullable();
            $table->string('masked_url')->nullable();
            $table->text('qr_code')->nullable();
            $table->unsignedBigInteger('visit_count')->default(0);
        });
    }
};
