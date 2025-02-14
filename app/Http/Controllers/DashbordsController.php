<?php

namespace App\Http\Controllers;

use App\Models\Assurances;
use App\Models\Conducteurs;
use App\Models\Essences;
use App\Models\Vehicules;
use App\Models\Versements;
use App\Models\Vidanges;
use App\Models\Visites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashbordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //////realisation des graphiques
         $i=0;  $j=0; $k=0; $o=0; $versemencduc=null; $reparationvehi=null; 
         if(Session::get('annee') !=null){$anne=Session::get('annee');} else{$anne=date('Y');}
//////les 12 mois de l'annee
           for ($i=0; $i <12 ; $i++) {
       
             if (($i+1)<10) {
                 $mois[]="0".($i+1);
             }else{
                 $mois[]=($i+1);
             }
             
             if(Session::get('vehicule'))
             {

             $versemencduc[]= Versements::where('supprimer',0)
                         ->whereMonth("date", $mois[$i])
                         ->whereYear('date', '=', $anne)
                         ->where('Rubrique', '=', "VERSEMENTS CONDUCTEUR")
                         ->where('vehicule_id', '=', Session::get('vehicule'))
                         ->sum('Montant');

             $reparationvehi[]= Versements::where('supprimer',0)
                         ->whereMonth("date", $mois[$i])
                         ->whereYear('date', '=', $anne)
                         ->where('Rubrique', '=', "RÉPARATION VÉHICULE")
                         ->where('vehicule_id', '=', Session::get('vehicule'))
                         ->sum('Montant');

             $vidangesgr[]= Versements::where('supprimer',0)
                         ->whereMonth("date", $mois[$i])
                         ->whereYear('date', '=', $anne)
                         ->where('Rubrique', '=', "VIDANGE VEHICULE")
                         ->where('vehicule_id', '=', Session::get('vehicule'))
                         ->sum('Montant');

             $entretiens[]= Versements::where('supprimer',0)
                         ->whereMonth("date", $mois[$i])
                         ->whereYear('date', '=', $anne)
                         ->where('Rubrique', '=', "ENTRETIENS VEHICULE")
                         ->where('vehicule_id', '=', Session::get('vehicule'))
                         ->sum('Montant');


            $essencesqte[]= Essences::whereMonth("Date", $mois[$i])
                        ->whereYear('Date', '=', $anne)
                        ->where('vehicule_id', '=', Session::get('vehicule'))
                        ->sum('QTELitre');

            $essencesprix[]= Essences::whereMonth("Date", $mois[$i])
                        ->whereYear('Date', '=', $anne)
                        ->where('vehicule_id', '=', Session::get('vehicule'))
                        ->sum('PrixLitre');

            $ttprix[]= Essences::whereMonth("Date", $mois[$i])
                        ->whereYear('Date', '=', $anne)
                        ->where('vehicule_id', '=', Session::get('vehicule'))
                        ->sum('Montant');
                    }else{

                $versemencduc[]= Versements::where('supprimer',0)
                         ->whereMonth("date", $mois[$i])
                         ->whereYear('date', '=', $anne)
                         ->where('Rubrique', '=', "VERSEMENTS CONDUCTEUR")
                         ->sum('Montant');

                $reparationvehi[]= Versements::where('supprimer',0)
                            ->whereMonth("date", $mois[$i])
                            ->whereYear('date', '=', $anne)
                            ->where('Rubrique', '=', "RÉPARATION VÉHICULE")
                            ->sum('Montant');

                $entretiens[]= Versements::where('supprimer',0)
                            ->whereMonth("date", $mois[$i])
                            ->whereYear('date', '=', $anne)
                            ->where('Rubrique', '=', "ENTRETIENS VEHICULE")
                            ->sum('Montant');

                $vidangesgr[]= Versements::where('supprimer',0)
                            ->whereMonth("date", $mois[$i])
                            ->whereYear('date', '=', $anne)
                            ->where('Rubrique', '=', "VIDANGE VEHICULE")
                            ->sum('Montant');

                $essencesqte[]= Essences::whereMonth("Date", $mois[$i])
                             ->whereYear('Date', '=', $anne)
                             ->sum('QTELitre');

                $essencesprix[]= Essences::whereMonth("Date", $mois[$i])
                             ->whereYear('Date', '=', $anne)
                             ->sum('PrixLitre');

                 $ttprix[]= Essences::whereMonth("Date", $mois[$i])
                             ->whereYear('Date', '=', $anne)
                             ->sum('Montant');
                            }


                        }
                        //dd($essencesprix, $essencesqte);
                        $vehicule= Vehicules::where('supprimer', 0)->where('Type', 'VOITURE')->count();
                        $motos= Vehicules::where('supprimer', 0)->where('Type', 'MOTO')->count();
                        $conducteur= Conducteurs::where('supprimer', 0)->count();
                         //dd($versemencduc);
                         $assurances= Assurances::where('Etat', 0)->get();
                         $visites= Visites::where('Etat', 0)->get();
                         $vidanges= Vidanges::where('Etat', 0)->get();
                       // dd($assurances);
        return view('dashboard.index')->with([
            'versemencduc'=>$versemencduc,'reparationvehi'=>$reparationvehi,
            'vehicule'=>$vehicule,'motos'=>$motos,'assurances'=>$assurances,
            'visites'=>$visites,'vidanges'=>$vidanges,'conducteur'=>$conducteur,
            'essencesqte'=>$essencesqte,'essencesprix'=>$essencesprix,'ttprix'=>$ttprix,
            'entretiens'=>$entretiens,'vidangesgr'=>$vidangesgr,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function anneegraphe(Request $request)
    {
      if($request->annee != null){
       $annee = $request->annee;
      }
      else{

        $annee=date('Y');
      }
      Session::put('annee',  $annee);
      return redirect()->back();
      // return json_encode(1);
    }
    public function vehiculegraphe(Request $request)
    {
      if($request->vehicule != null){
       $vehicule = $request->vehicule;
      }
      Session::put('vehicule',  $vehicule);
      return redirect()->back();
      // return json_encode(1);
    }
}
