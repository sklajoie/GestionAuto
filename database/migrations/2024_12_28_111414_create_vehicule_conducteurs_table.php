<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicule_conducteurs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateAsignation');
            $table->date('dateFinAsigne')->nullable();
            $table->float('recetteJournalier')->nullable();
            $table->string('Status')->nullable();
            $table->boolean('Etat')->default(0);

            $table->unsignedBigInteger('conducteur_id')->nullable();
            $table->foreign('conducteur_id')->references('id')->on('conducteurs')->onDelete('set null');

            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('vehicule_conducteurs');
    }
};
