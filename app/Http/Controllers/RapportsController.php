<?php

namespace App\Http\Controllers;

use App\Models\Vehicules;
use App\Models\Versements;
use Illuminate\Http\Request;

class RapportsController extends Controller
{
    public function rapportglobale()
    {

        $moyenpaiements=Versements::select('MoyenPaiemet')
                                    ->distinct()
                                    ->get();

        $rubriques=Versements::select('Rubrique')
                                    ->distinct()
                                    ->get();

        return view('rapports.index')->with([
            'moyenpaiements'=>$moyenpaiements,'rubriques'=>$rubriques,
        ]);

    }

    public function rapportvehicule(Request $request)
    {
        $datedebut=$request->datedebut;
        $datefin=$request->datefin;
        $idvehicule=$request->input('vehicule');
           //dd($vehicule);
        $dataByMonth = [];
        $totalByMonthYear = [];
        $totalByMouvementent = [];
        $totalByMouvementsrt = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];

        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $vehicule= Vehicules::where('supprimer', 0)->first();

        if($idvehicule == "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('supprimer', 0)->get();
            }
        elseif($idvehicule != "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        elseif($idvehicule != "TOUT" &&  $datedebut == null &&  $datefin == null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        else{
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            // ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }

//dd($rapport);


            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                // if (!isset($totalByMonthYear[$month])) {
                //     $totalByMonthYear[$month] = 0;
                // }
                // $totalByMonthYear[$month] += $rappor->Montant;
                
                if (!isset($totalByMouvement[$month])) {$totalByMouvement[$month] = 0;}
                if (!isset($totalByMouvementstr[$month])) { $totalByMouvementstr[$month] = 0;}

                if( $mouvement=="ENTREE EN CAISSE"){
                $totalByMouvement[$month] += $rappor->Montant;
                   }
                if( $mouvement=="SORTIE DE CAISSE"){
                $totalByMouvementstr[$month] += $rappor->Montant;
                   }
            }                                          
          // dd($totalByMouvement);
        
        return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);

    }


    public function getrapportsemployer(Request $request)
    {
        $datedebut=$request->datedebut;
        $datefin=$request->datefin;
        $idmembre=$request->input('idmembre');
           //dd($vehicule);
        $dataByMonth = [];
        $totalByMonthYear = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];

        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $vehicule= Vehicules::where('supprimer', 0)->first();

        if($idmembre == "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('supprimer', 0)->get();
            }
        elseif($idmembre != "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('conducteur_id', $idmembre)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        elseif($idmembre != "TOUT" &&  $datedebut == null &&  $datefin == null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('conducteur_id', $idmembre)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        else{
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            // ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }

//dd($rapport);


            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                // if (!isset($totalByMonthYear[$month])) {
                //     $totalByMonthYear[$month] = 0;
                // }
                // $totalByMonthYear[$month] += $rappor->Montant;
                
                if (!isset($totalByMouvement[$month])) {$totalByMouvement[$month] = 0;}
                if (!isset($totalByMouvementstr[$month])) { $totalByMouvementstr[$month] = 0;}

                if( $mouvement=="ENTREE EN CAISSE"){
                $totalByMouvement[$month] += $rappor->Montant;
                   }
                if( $mouvement=="SORTIE DE CAISSE"){
                $totalByMouvementstr[$month] += $rappor->Montant;
                   }
            }                                          
          // dd($totalByMouvement);
        
        return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);

    }
    public function rapportsmoyenspaiement(Request $request)
    {
        $datedebut=$request->datedebut;
        $datefin=$request->datefin;
        $moyensp=$request->input('moyensp');
           //dd($vehicule);
        $dataByMonth = [];
        $totalByMonthYear = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];

        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $vehicule= Vehicules::where('supprimer', 0)->first();

        if($moyensp == "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('supprimer', 0)->get();
            }
        elseif($moyensp != "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('MoyenPaiemet', $moyensp)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        elseif($moyensp != "TOUT" &&  $datedebut == null &&  $datefin == null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('MoyenPaiemet', $moyensp)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        else{
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            // ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }

//dd($rapport);


            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                // if (!isset($totalByMonthYear[$month])) {
                //     $totalByMonthYear[$month] = 0;
                // }
                // $totalByMonthYear[$month] += $rappor->Montant;
                
                if (!isset($totalByMouvement[$month])) {$totalByMouvement[$month] = 0;}
                if (!isset($totalByMouvementstr[$month])) { $totalByMouvementstr[$month] = 0;}

                if( $mouvement=="ENTREE EN CAISSE"){
                $totalByMouvement[$month] += $rappor->Montant;
                   }
                if( $mouvement=="SORTIE DE CAISSE"){
                $totalByMouvementstr[$month] += $rappor->Montant;
                   }
            }                                          
          // dd($totalByMouvement);
        
        return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);

    }


    public function getrapportsrubriques(Request $request)
    {
        $datedebut=$request->datedebut;
        $datefin=$request->datefin;
        $rubrique=$request->input('rubrique');
           //dd($vehicule);
        $dataByMonth = [];
        $totalByMonthYear = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];

        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $vehicule= Vehicules::where('supprimer', 0)->first();

        if($rubrique == "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('supprimer', 0)->get();
            }
        elseif($rubrique != "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('Rubrique', $rubrique)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        elseif($rubrique != "TOUT" &&  $datedebut == null &&  $datefin == null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            ->where('Rubrique', $rubrique)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }
        else{
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->whereBetween('date', [$datedebut, $datefin])
                                                            // ->where('vehicule_id', $idvehicule)
                                                            ->where('supprimer', 0)
                                                            ->get();
            }

//dd($rapport);


            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                // if (!isset($totalByMonthYear[$month])) {
                //     $totalByMonthYear[$month] = 0;
                // }
                // $totalByMonthYear[$month] += $rappor->Montant;
                
                if (!isset($totalByMouvement[$month])) {$totalByMouvement[$month] = 0;}
                if (!isset($totalByMouvementstr[$month])) { $totalByMouvementstr[$month] = 0;}

                if( $mouvement=="ENTREE EN CAISSE"){
                $totalByMouvement[$month] += $rappor->Montant;
                   }
                if( $mouvement=="SORTIE DE CAISSE"){
                $totalByMouvementstr[$month] += $rappor->Montant;
                   }
            }                                          
          // dd($totalByMouvement);
        
        return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);

    }
    public function getrapportsmouvements(Request $request)
    {
        $datedebut=$request->datedebut;
        $datefin=$request->datefin;
        $mouvement=$request->input('mouvement');
           //dd($vehicule);
        $dataByMonth = [];
        $totalByMonthYear = [];
        $totalByMouvement = [];
        $totalByMouvementstr = [];

        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $vehicule= Vehicules::where('supprimer', 0)->first();

        if($mouvement == "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                    'Beneficier','conducteur_id','vehicule_id','user_id',)
                                    ->whereBetween('date', [$datedebut, $datefin])
                                    ->where('supprimer', 0)->get();
            }
        elseif($mouvement != "TOUT" &&  $datedebut != null &&  $datefin != null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                    'Beneficier','conducteur_id','vehicule_id','user_id',)
                                    ->whereBetween('date', [$datedebut, $datefin])
                                    ->where('Mouvement', $mouvement)
                                    ->where('supprimer', 0)
                                    ->get();
            }
        elseif($mouvement != "TOUT" &&  $datedebut == null &&  $datefin == null)
            {
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                    'Beneficier','conducteur_id','vehicule_id','user_id',)
                                    // ->whereBetween('date', [$datedebut, $datefin])
                                    ->where('Mouvement', $mouvement)
                                    ->where('supprimer', 0)
                                    ->get();
            }
        else{
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                    'Beneficier','conducteur_id','vehicule_id','user_id',)
                                    // ->whereBetween('date', [$datedebut, $datefin])
                                    // ->where('vehicule_id', $idvehicule)
                                    ->where('supprimer', 0)
                                    ->get();
            }

//dd($rapport);


            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                // if (!isset($totalByMonthYear[$month])) {
                //     $totalByMonthYear[$month] = 0;
                // }
                // $totalByMonthYear[$month] += $rappor->Montant;
                
                if (!isset($totalByMouvement[$month])) {$totalByMouvement[$month] = 0;}
                if (!isset($totalByMouvementstr[$month])) { $totalByMouvementstr[$month] = 0;}

                if( $mouvement=="ENTREE EN CAISSE"){
                $totalByMouvement[$month] += $rappor->Montant;
                   }
                if( $mouvement=="SORTIE DE CAISSE"){
                $totalByMouvementstr[$month] += $rappor->Montant;
                   }
            }                                          
          // dd($totalByMouvement);
        
        return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);

    }


}
