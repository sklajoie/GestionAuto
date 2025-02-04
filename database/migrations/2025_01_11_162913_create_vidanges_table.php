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
        Schema::create('vidanges', function (Blueprint $table) {
            $table->id();
            $table->date('DateVidange')->nullable();
            $table->date('DateFin')->nullable();
            $table->string('KiloVidange')->nullable();
            $table->string('MarqueHuile')->nullable();
            $table->string('KiloHuile')->nullable();
            $table->string('KiloProchainVidange')->nullable();
            $table->text('Details')->nullable();
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
        Schema::dropIfExists('vidanges');
    }
};
