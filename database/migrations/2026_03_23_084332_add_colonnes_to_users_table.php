<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (!Schema::hasColumn('users', 'nom')) {
                $table->string('nom')->after('id');
            }
            if (!Schema::hasColumn('users', 'prenom')) {
                $table->string('prenom')->after('nom');
            }

    

            if (!Schema::hasColumn('users', 'telephone')) {
                $table->string('telephone')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'adresse')) {
                $table->string('adresse')->nullable()->after('telephone');
            }
            if (!Schema::hasColumn('users', 'date_naissance')) {
                $table->date('date_naissance')->nullable()->after('adresse');
            }
            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('date_naissance');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nom','prenom','telephone','adresse','date_naissance','photo']);
            $table->string('name')->after('id');
        });
    }
};