<?php

use App\Http\Controllers\AssurancesController;
use App\Http\Controllers\ConducteursController;
use App\Http\Controllers\DashbordsController;
use App\Http\Controllers\EntretiensController;
use App\Http\Controllers\EssencesController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\RapportsController;
use App\Http\Controllers\ReparationsController;
use App\Http\Controllers\RessourcesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculeConducteursController;
use App\Http\Controllers\VehiculesController;
use App\Http\Controllers\VersementsController;
use App\Http\Controllers\VidangesController;
use App\Http\Controllers\VisitesController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group([
    "middleware" =>  ["auth.admin"],
    // "as" => "admin."
  ], function(){

Route::get('/Accueil', [DashbordsController::class, 'index'])->name('Accueil');
Route::resource('/Vehicules', VehiculesController::class);
Route::resource('/Conducteurs', ConducteursController::class);
Route::resource('/Reparations', ReparationsController::class);
Route::resource('/Versements', VersementsController::class);
Route::resource('/VehiculeConducteur', VehiculeConducteursController::class);
Route::resource('/Ressources', RessourcesController::class);
Route::resource('/Assurances', AssurancesController::class);
Route::resource('/Visites', VisitesController::class);
Route::resource('/Vidanges', VidangesController::class);
Route::resource('/Users', UserController::class);
Route::resource('/Locations', LocationsController::class);
Route::resource('/Entretiens', EntretiensController::class);
Route::resource('/Essences', EssencesController::class);

Route::post('/Annee-Graphe', [DashbordsController::class, 'anneegraphe'])->name('Annee-Graphe');
Route::post('/Vehicule-Graphe', [DashbordsController::class, 'vehiculegraphe'])->name('Vehicule-Graphe');
Route::get('/Liste-Vehicules', [VehiculesController::class, 'getvehicule'])->name('Liste-Vehicules');
 Route::get('/recherche-type-mvmt/{id}', [VersementsController::class, 'recherchetypemvmt'])->name('recherche-type-mvmt');
 Route::get('/Panne-Vehicule/{id}', [ReparationsController::class, 'pannevehicule'])->name('Panne-Vehicule');
 Route::get('/Versement-Vehicule/{id}', [VersementsController::class, 'versementvehicule'])->name('Versement-Vehicule');
 Route::get('/active-user/{id}', [UserController::class, 'activeuser'])->name('active-user');
 Route::get('/deactive-user/{id}', [UserController::class, 'deactiveuser'])->name('deactive-user');

 Route::get('/rapports', [RapportsController::class, 'rapportglobale'])->name('rapports');
 Route::get('/Rapports-Vehicues', [RapportsController::class, 'rapportvehicule'])->name('Rapports-Vehicues');
 Route::get('/Rapports-Employer', [RapportsController::class, 'getrapportsemployer'])->name('Rapports-Employer');
 Route::get('/Rapports-Moyens-Paiement', [RapportsController::class, 'rapportsmoyenspaiement'])->name('Rapports-Moyens-Paiement');
 Route::get('/Rapports-Rubriques', [RapportsController::class, 'getrapportsrubriques'])->name('Rapports-Rubriques');
 Route::get('/Rapports-Mouvements', [RapportsController::class, 'getrapportsmouvements'])->name('Rapports-Mouvements');
 
 Route::post('/Add-Conducteur-Location', [LocationsController::class, 'postConducteurlocation'])->name('Add-Conducteur-Location');
 Route::post('/Add-versement-Location', [LocationsController::class, 'postversementlocation'])->name('Add-versement-Location');



});
 Route::post('Login-Submit', [UserController::class, 'postuserlogin'])->name('Login-Submit');
 Route::get('/', [UserController::class, 'connexion'])->name('login');
 Route::get('/Logout', [UserController::class, 'deconnexion'])->name('Logout');
 Route::get('/test-mail', [VehiculeConducteursController::class, 'mailrapportvehicule'])->name('test-mail');
