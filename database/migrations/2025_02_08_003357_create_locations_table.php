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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('Client')->nullable();
            $table->string('Contact')->nullable();
            $table->string('Address')->nullable();
            $table->float('Montant')->nullable();
            $table->string('KmDebut')->nullable();
            $table->string('KmFin')->nullable();
            $table->date('DateDebut')->nullable();
            $table->date('DateFin')->nullable();
            $table->boolean('Etat')->default(0);
            $table->string('Status')->nullable();
            $table->text('Details')->nullable();
            $table->text('Piece')->nullable();
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
        Schema::dropIfExists('locations');
    }
};
