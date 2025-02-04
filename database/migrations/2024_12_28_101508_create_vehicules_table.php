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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('Matriculation')->unique();
            $table->string('Marque')->nullable();
            $table->string('Model')->nullable();
            $table->string('Chassis')->nullable();
            $table->string('NombrePlace')->nullable();
            $table->date('DateAcquisition')->nullable();
            $table->string('Couleur')->nullable();
            $table->string('Status')->nullable();
            $table->string('Type')->nullable();
            $table->boolean('Active')->default(0);
            $table->boolean('supprimer')->default(0);
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
        Schema::dropIfExists('vehicules');
    }
};
