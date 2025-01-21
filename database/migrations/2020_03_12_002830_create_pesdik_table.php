<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePesdikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesdik', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 7);
            $table->string('nama', 30);
            $table->string('jenis_kelamin', 12);
            $table->string('nisn', 10);
            // $table->string('tempat_lahir');
            // $table->date('tanggal_lahir');
            $table->string('bank_untuk_pip');
            $table->integer('data_wali_murid')->nullable()->unsigned();
            $table->integer('data_ayah_kandung')->nullable()->unsigned();
            $table->integer('data_ibu_kandung')->nullable()->unsigned();
            $table->integer('kontak');
            $table->string('induk', 6);
            $table->integer('rombel_id')->unsigned();
            $table->string('tempat_lahir', 25);
            $table->date('tanggal_lahir');
            $table->string('jenis_pendaftaran', 10);
            $table->date('tanggal_masuk');

            //  $table->string('nama');
            // $table->enum('jenis_kelamin',['P','L']);
            // $table->integer('nisn', 10);
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
        Schema::dropIfExists('pesdik');
    }
}
