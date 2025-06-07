<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresencesTable extends Migration
{
    public function up()
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->enum('status', ['hadir', 'tidak hadir', 'izin', 'sakit'])->default('hadir');
            $table->string('keterangan')->nullable();

            $table->dateTime('scan_time');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('presences');
    }
}
