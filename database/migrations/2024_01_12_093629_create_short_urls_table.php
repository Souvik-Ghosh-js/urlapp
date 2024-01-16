<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlsTable extends Migration
{
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('long_url_id');
            $table->string('short_url');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('long_url_id')->references('id')->on('urls');
        });
    }

    public function down()
    {
        Schema::dropIfExists('short_urls');
    }
}
