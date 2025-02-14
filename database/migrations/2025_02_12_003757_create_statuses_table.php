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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('Etape')->nullable();
            $table->string('Details')->nullable();
            $table->string('Date')->nullable();

            $table->unsignedBigInteger('entretien_id')->nullable();
            $table->foreign('entretien_id')->references('id')->on('entretiens')->onDelete('set null');

            $table->unsignedBigInteger('essence_id')->nullable();
            $table->foreign('essence_id')->references('id')->on('essences')->onDelete('set null');

            $table->unsignedBigInteger('vidange_id')->nullable();
            $table->foreign('vidange_id')->references('id')->on('vidanges')->onDelete('set null');

            $table->unsignedBigInteger('visite_id')->nullable();
            $table->foreign('visite_id')->references('id')->on('visites')->onDelete('set null');

            $table->unsignedBigInteger('assurance_id')->nullable();
            $table->foreign('assurance_id')->references('id')->on('assurances')->onDelete('set null');

            $table->unsignedBigInteger('versement_id')->nullable();
            $table->foreign('versement_id')->references('id')->on('versements')->onDelete('set null');

            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('set null');


            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            
            $table->unsignedBigInteger('conducteur_id')->nullable();
            $table->foreign('conducteur_id')->references('id')->on('conducteurs')->onDelete('set null');

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
        Schema::dropIfExists('statuses');
    }
};
