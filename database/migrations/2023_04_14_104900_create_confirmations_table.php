<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmations', function (Blueprint $table) {
            $table->id();
            $table->string('code_value');
            $table->dateTime('expiry_time');
            $table->string('confirmation_method');
            $table->unsignedBigInteger('user_setting_id');
            $table->timestamps();
            $table->foreign('user_setting_id')->references('id')->on('user_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmations');
    }
}
