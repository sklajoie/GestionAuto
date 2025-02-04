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
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->float('Montant');
            $table->string('MoyenPaiemet');
            $table->string('Reference')->nullable();
            $table->string('Details')->nullable();
            $table->string('Status')->nullable();
            $table->string('Rubrique')->nullable();
            $table->string('Type')->nullable();
            $table->string('Beneficier')->nullable();
            $table->string('Mouvement')->nullable();
            $table->string('codePaiement')->nullable();
            $table->text('pieceJointe')->nullable();
            $table->date('date')->nullable();

            $table->unsignedBigInteger('conducteur_id')->nullable();
            $table->foreign('conducteur_id')->references('id')->on('conducteurs')->onDelete('set null');

            $table->unsignedBigInteger('vehicule_id')->nullable();
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
            $table->boolean('supprimer')->default(0);
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
        Schema::dropIfExists('versements');
    }
};
