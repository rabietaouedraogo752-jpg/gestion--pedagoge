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
    Schema::create('cours', function (Blueprint $table) {
        $table->id();
        $table->foreignId('matiere_id')->constrained(); // Lien vers matieres
        $table->foreignId('user_id')->constrained();    // Lien vers users (enseignant)
        $table->string('niveau');
        $table->string('jour');
        $table->time('horaire');
       
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
        Schema::dropIfExists('cours');
    }
};
