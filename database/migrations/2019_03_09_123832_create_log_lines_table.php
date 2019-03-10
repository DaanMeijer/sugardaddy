<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_lines', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('log_upload_id');
            $table->foreign('log_upload_id')->references('id')->on('log_uploads');

            //Meter,Serienummer,Tijdstempel meter,Gegevenstype,Historische glucose(mmol/l),Scan Glucose(mmol/l),Niet-numerieke snelwerkende insuline,Snelwerkende insuline (eenheden),Niet-numeriek voedsel,Koolhydraten (gram),Koolhydraten (porties),Niet-numerieke langwerkende insuline,Langwerkende insuline (eenheden),Notities,Strip Glucose(mmol/l),Keton(mmol/l),Maaltijdinsuline (eenheden),Correctie insuline (eenheden),Wijzigen insuline gebruiker (eenheden)

            $table->timestamp('timestamp');

            $table->decimal('historic_glucose', 5,2)->nullable();
            $table->decimal('scan_glucose', 5,2)->nullable();
            $table->decimal('strip_glucose', 5,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_lines');
    }
}
