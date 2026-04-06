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
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cour_id')->constrained('cours')->onDelete('cascade'); // Lien vers matieres
           
            $table->string('titre_du_chapitre')->nullable();
            $table->text('contenu_du_texte')->nullable();
            $table->string('fichier_joint')->nullable();
       
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
        Schema::dropIfExists('contenus');
    }
};
