<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address');
            $table->text('user_agent');
            $table->text('referrer')->nullable();

            // Foreign key for short_urls
            $table->unsignedBigInteger('short_url_id')->nullable();
            $table->foreign('short_url_id')->references('id')->on('short_urls');

            // Foreign key for masked_urls
            $table->unsignedBigInteger('masked_url_id')->nullable();
            $table->foreign('masked_url_id')->references('id')->on('masked_urls');

            // Foreign key for qr_codes
            $table->unsignedBigInteger('qr_code_id')->nullable();
            $table->foreign('qr_code_id')->references('id')->on('gen_qr');

            $table->timestamps();
        });
    }

};
