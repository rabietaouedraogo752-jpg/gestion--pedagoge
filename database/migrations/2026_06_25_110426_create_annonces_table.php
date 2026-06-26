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
    Schema::create('annonces', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('departement_id');
        $table->string('titre');
        $table->text('contenu');
        $table->string('cible_niveau')->nullable(); // Optionnel : pour cibler une classe (ex: Licence 2)
        $table->timestamps();

        $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('annonces');
    }
};
