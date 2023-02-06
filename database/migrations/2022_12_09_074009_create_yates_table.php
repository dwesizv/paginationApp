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
        Schema::create('yate', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduser');
            $table->foreignId('idastillero');
            $table->foreignId('idtipo');
            $table->string('nombre', 100)->unique();
            $table->text('descripcion');
            $table->decimal('precio', 12, 2);
            $table->timestamps();
            $table->foreign('iduser')->references('id')->on('users');
            $table->foreign('idastillero')->references('id')->on('astillero');
            $table->foreign('idtipo')->references('id')->on('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yate');
    }
};