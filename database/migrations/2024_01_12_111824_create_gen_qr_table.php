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
        Schema::create('gen_qr', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code');
            $table->unsignedBigInteger('long_url_id');
            $table->unsignedInteger('visit_count')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gen_qr');
    }
};
