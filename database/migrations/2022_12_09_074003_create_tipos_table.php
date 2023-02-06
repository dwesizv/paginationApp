<?php

use App\Models\Tipo;
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
        Schema::create('tipo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->tinyInteger('desde');
            $table->tinyInteger('hasta');
        });
        
        $yate = new Tipo();
        $yate->nombre = 'normal';
        $yate->desde = '0';
        $yate->hasta = '12';
        $yate->save();
        $yate = new Tipo();
        $yate->nombre = 'lujo';
        $yate->desde = '13';
        $yate->hasta = '30';
        $yate->save();
        $yate = new Tipo();
        $yate->nombre = 'mega';
        $yate->desde = '31';
        $yate->hasta = '60';
        $yate->save();
        $yate = new Tipo();
        $yate->nombre = 'súper';
        $yate->desde = '61';
        $yate->hasta = '100';
        $yate->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo');
    }
};