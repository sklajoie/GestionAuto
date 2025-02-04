<?php

namespace App\Http\Controllers;

use App\Mail\SendRapport;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use App\Models\Vehicules;
use App\Models\Versements;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VehiculeConducteursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'dateAsignation' => 'required',
           ]);

           try { 

            $check=VehiculeConducteurs::WHERE('vehicule_id', $request->vehicule)->first();
           // dd($check);
           if($check)
           {
              $check->update(['Etat'=>0,'Status'=>"FIN ASSIGNATION", 'dateFinAsigne'=> $request->dateAsignation,'user_id'=> Auth::user()->id,]);
           }

           VehiculeConducteurs::create([
                    'dateAsignation'=> $request->dateAsignation,
                    'recetteJournalier'=> $request->recetteJournalier,
                    'conducteur_id'=> $request->conducteur,
                    'vehicule_id'=> $request->vehicule,
                    'dateFinAsigne'=> $request->dateFinAsigne,
                    'Etat'=> 1,
                    'Status'=> "ASSIGNE",
                    'user_id'=> Auth::user()->id,
           ]);
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->withErrors($request->all())->withInput()->with('danger', "Les données enregistrements ne sont pas correctes merci de verrifier !!! "); 
          }

    return redirect()->back()->with('success', "l'Enregistrement a été effectué avec success");
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

    public function mailrapportvehicule()
    {
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $vehicule= Vehicules::select('Matriculation','Marque','Model','Type',)->where('supprimer', 0)->first();
        $rapport= Versements::select('Montant','MoyenPaiemet','Reference','Rubrique','date','Mouvement',
                                                            'Beneficier','conducteur_id','vehicule_id','user_id',)
                                                            // ->distinct()
                                                            ->where('supprimer', 0)->get();
            
            
            $dataByMonth = [];
             $totalByMonthYear = [];
             $totalByMouvement = [];
             $totalByMouvementstr = [];
            foreach($rapport as $rappor) {
                $month = date('Y-m', strtotime($rappor->date));
                $dataByMonth[$month][] = $rappor;
                $mouvement = $rappor->Mouvement;

                
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
          $email ='kigninnama@gmail.com';
          Mail::to($email)->send(new SendRapport($rapport,$vehicule,$totalByMouvement,$dataByMonth,$totalByMonthYear,$totalByMouvementstr)); 
        
          return view('pdf.rapport_vehicules')->with([
            'rapport'=>$rapport,'vehicule'=>$vehicule,'totalByMouvement'=>$totalByMouvement,
            'dataByMonth'=>$dataByMonth,'totalByMonthYear'=>$totalByMonthYear,'totalByMouvementstr'=>$totalByMouvementstr,
        ]);
    }
}
