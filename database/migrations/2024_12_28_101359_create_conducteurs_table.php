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
        Schema::create('conducteurs', function (Blueprint $table) {
            $table->id();
            $table->string('NomPrenom');
            $table->string('Contact');
            $table->string('Email')->nullable();
            $table->string('Address')->nullable();
            $table->string('Reference')->nullable();
            $table->string('Status')->nullable();
            $table->text('Permis')->nullable();
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
        Schema::dropIfExists('conducteurs');
    }
};
