<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaliMuridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_murid', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('jenis_wali_murid', ['Ayah Kandung','Ibu Kandung','Wali']);
            $table->string('nama');
            $table->integer('NIK');
            $table->string('jenis_kelamin');
            $table->string('nama_anak', 225)->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wali_murid');
    }
}
