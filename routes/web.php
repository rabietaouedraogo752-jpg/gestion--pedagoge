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
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/matieres', [PageMatiereController::class, 'index']);
Route::get('/matieres/creer', [PageMatiereController::class, 'create']);
Route::post('/matieres/envoyer', [PageMatiereController::class, 'store']);
Route::get('/matieres/modifier/{id}',[PageMatiereController::class,'edit']);
Route::put('/matieres/modifier/{id}', [PageMatiereController::class, 'update']);
Route::delete('/matieres/supprimer/{id}', [PageMatiereController::class, 'destroy']);

Route::get('/etudiants', [EtudiantEnseignantController::class, 'indexEtudiants']);
Route::get('/etudiants/creer', [EtudiantEnseignantController::class, 'createEtudiant']);
Route::post('/etudiants/envoyer', [EtudiantEnseignantController::class, 'storeEtudiant']);
Route::get('/etudiants/modifier/{id}',[EtudiantEnseignantController::class,'editEtudiant']);
Route::put('/etudiants/modifier/{id}', [EtudiantEnseignantController::class, 'updateEtudiant']);
Route::delete('/etudiants/supprimer/{id}', [EtudiantEnseignantController::class, 'destroyEtudiant']);

Route::get('/enseignants', [EtudiantEnseignantController::class, 'indexEnseignants']);
Route::get('/enseignants/creer', [EtudiantEnseignantController::class, 'createEnseignants']);
Route::post('/enseignants/envoyer', [EtudiantEnseignantController::class, 'storeEnseignant']);
Route::get('/enseignants/modifier/{id}',[EtudiantEnseignantController::class,'editEnseignant']);
Route::put('/enseignants/modifier/{id}', [EtudiantEnseignantController::class, 'updateEnseignant']);
Route::delete('/enseignants/supprimer/{id}', [EtudiantEnseignantController::class, 'destroyEnseignant']);

Route::get('/notes', [NoteController::class, 'index']);
Route::get('/notes/creer/{user_id}/{matiere_id}', [NoteController::class, 'create']);
Route::post('/notes/envoyer', [NoteController::class, 'store']);
Route::delete('/notes/supprimer/{id}', [NoteController::class, 'destroy']);
Route::get('/notes/modifier/{id}',[NoteController::class,'edit']);
Route::put('/notes/modifier/{id}', [NoteController::class, 'update']);

Route::get('/cours', [CourController::class, 'index']);
Route::get('/cours/creer', [CourController::class, 'create']);
Route::post('/cours/envoyer', [CourController::class, 'store']);
Route::delete('/cours/supprimer/{id}', [CourController::class, 'destroy']);
Route::get('/cours/modifier/{id}',[CourController::class,'edit']);
Route::put('/cours/modifier/{id}', [CourController::class, 'update']);

// davy
// Test simple sans aucun middleware
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/',             [ProfilController::class, 'show'])->name('show');
    Route::get('/modifier',     [ProfilController::class, 'edit'])->name('edit');
    Route::put('/modifier',     [ProfilController::class, 'update'])->name('update');
    Route::put('/mot-de-passe', [ProfilController::class, 'updatePassword'])->name('password');
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test-etudiant', function () {
    // 1. On récupère les données réelles pour le test
    $toutesMatieres = \App\Models\Matiere::all();
    $mesNotes = \App\Models\Note::all(); // ou une liste vide [] pour tester
    $mesCours = \App\Models\Cour::all(); // ou une liste vide [] pour tester

    // 2. On les envoie à la vue accueil.blade.php
    return view('rabieta.etudiant.accueil', compact('toutesMatieres', 'mesNotes', 'mesCours'));
});

Route::get('/test-enseignant', function () {
    // 1. On récupère tous les cours avec leurs relations pour le test
    $mesCours = \App\Models\Cour::with('matiere')->get();

    // 2. On les envoie à la vue accueil.blade.php
    return view('rabieta.enseignant.accueil', compact('mesCours'));
});

// Route pour afficher le formulaire d'ajout
Route::get('/enseignant/cours/{id}/contenu', [App\Http\Controllers\CourController::class, 'creerContenu']);

// Route pour l'enregistrement (POST)
Route::post('/contenu/enregistrer', [App\Http\Controllers\CourController::class, 'sauvegarderContenu']);

