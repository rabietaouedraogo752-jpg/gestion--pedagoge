<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageMatiereController;
use App\Http\Controllers\EtudiantEnseignantController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CourController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (PAS DE CONNEXION)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);

Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTES PROTÉGÉES (UTILISATEUR CONNECTÉ)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |---------------- PROFIL ----------------
    */
    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [ProfilController::class, 'show'])->name('show');
        Route::get('/modifier', [ProfilController::class, 'edit'])->name('edit');
        Route::put('/modifier', [ProfilController::class, 'update'])->name('update');
        Route::put('/mot-de-passe', [ProfilController::class, 'updatePassword'])->name('password');
    });

});


/*
|--------------------------------------------------------------------------
| ROUTES ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])->group(function () {

    // MATIERES
    Route::get('/matieres', [PageMatiereController::class, 'index']);
    Route::get('/matieres/creer', [PageMatiereController::class, 'create']);
    Route::post('/matieres/envoyer', [PageMatiereController::class, 'store']);
    Route::get('/matieres/modifier/{id}', [PageMatiereController::class, 'edit']);
    Route::put('/matieres/modifier/{id}', [PageMatiereController::class, 'update']);
    Route::delete('/matieres/supprimer/{id}', [PageMatiereController::class, 'destroy']);

    // ETUDIANTS
    Route::get('/etudiants', [EtudiantEnseignantController::class, 'indexEtudiants']);
    Route::get('/etudiants/creer', [EtudiantEnseignantController::class, 'createEtudiant']);
    Route::post('/etudiants/envoyer', [EtudiantEnseignantController::class, 'storeEtudiant']);
    Route::get('/etudiants/modifier/{id}', [EtudiantEnseignantController::class, 'editEtudiant']);
    Route::put('/etudiants/modifier/{id}', [EtudiantEnseignantController::class, 'updateEtudiant']);
    Route::delete('/etudiants/supprimer/{id}', [EtudiantEnseignantController::class, 'destroyEtudiant']);

    // ENSEIGNANTS
    Route::get('/enseignants', [EtudiantEnseignantController::class, 'indexEnseignants']);
    Route::get('/enseignants/creer', [EtudiantEnseignantController::class, 'createEnseignants']);
    Route::post('/enseignants/envoyer', [EtudiantEnseignantController::class, 'storeEnseignant']);
    Route::get('/enseignants/modifier/{id}', [EtudiantEnseignantController::class, 'editEnseignant']);
    Route::put('/enseignants/modifier/{id}', [EtudiantEnseignantController::class, 'updateEnseignant']);
    Route::delete('/enseignants/supprimer/{id}', [EtudiantEnseignantController::class, 'destroyEnseignant']);

    // NOTES
    Route::get('/notes', [NoteController::class, 'index']);
    Route::get('/notes/creer/{user_id}/{matiere_id}', [NoteController::class, 'create']);
    Route::post('/notes/envoyer', [NoteController::class, 'store']);
    Route::get('/notes/modifier/{id}', [NoteController::class, 'edit']);
    Route::put('/notes/modifier/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/supprimer/{id}', [NoteController::class, 'destroy']);

    // COURS
    Route::get('/cours', [CourController::class, 'index']);
    Route::get('/cours/creer', [CourController::class, 'create']);
    Route::post('/cours/envoyer', [CourController::class, 'store']);
    Route::get('/cours/modifier/{id}', [CourController::class, 'edit']);
    Route::put('/cours/modifier/{id}', [CourController::class, 'update']);
    Route::delete('/cours/supprimer/{id}', [CourController::class, 'destroy']);

});


/*
|--------------------------------------------------------------------------
| ROUTES ENSEIGNANT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:enseignant'])->group(function () {

    Route::get('/enseignant/cours/{id}/contenu',
        [CourController::class, 'creerContenu']);

    Route::post('/contenu/enregistrer',
    [CourController::class, 'sauvegarderContenu']);

    Route::get('/enseignant/cours/{id}/notes',[NoteController::class, 'indexEnseignant']);

     Route::post('/enseignant/cours/{id}/notes',
    [NoteController::class, 'sauvegarderNotes']);
});


/*
|--------------------------------------------------------------------------
| ROUTES ETUDIANT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:etudiant'])->group(function () {

    Route::get('/etudiant/cours/{id}',
        [CourController::class, 'afficherDétails']);
});