<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vehicules;
use App\Models\Versements;
use App\Models\Conducteurs;
use App\Models\Reparations;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ReparationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pannes=Reparations::WHERE('supprimer', 0)->OrderBy('id','DESC')->get();
        $conducteurs=Conducteurs::WHERE('supprimer', 0)->get();
        $vehicules=Vehicules::WHERE('supprimer', 0)->get();

        return view('reparations.index')->with([
           'pannes'=>$pannes,'conducteurs'=>$conducteurs,'vehicules'=>$vehicules,
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
        $this->validate($request,[
            'typePanne' => 'required',
            'datePanne' => 'required',
            'conducteur' => 'required',
            'vehicule' => 'required',
           ]);

          
            

           $grandnumg=Reparations::max('id');
           $Newnumero = $grandnumg +1;
                       if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'RE000'.$Newnumero ;}
                       elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'RE00'.$Newnumero ;} 
                       elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'RE0'.$Newnumero ;} 
                       else{$Newnumero = 'RE'.$Newnumero ;}


           try { 
           Reparations::create([
                    'typePanne'=> $request->typePanne,
                    'CoutPanne'=> $request->coutPanne,
                    'DatePanne'=> $request->datePanne,
                    'vehicule_id'=> $request->vehicule,
                    'conducteur_id'=> $request->conducteur,
                    'DetailsPanne'=> $request->detailpane,
                    'Active'=> 0,
                    'Status'=> $request->status,
                    'user_id'=> Auth::user()->id,
                    'Reference'=> $Newnumero,
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
        $panne=Reparations::where('supprimer', 0)->where('id', $id)->first();
        $conducteurs=Conducteurs::where('supprimer', 0)->get();
        $vehicules=Vehicules::where('supprimer', 0)->get();

        return view('reparations.addReparation')->with([
            'panne'=>$panne,'conducteurs'=>$conducteurs,'vehicules'=>$vehicules,
        ]);
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
        

           $reparer = Reparations::findOrFail($id);

           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;
           
           if($request->panne == 'PANNE')
           {

               $reparer->update([
                        'typePanne'=> $request->typePanne,
                        'CoutPanne'=> $request->coutPanne,
                        'DatePanne'=> $request->datePanne,
                        'vehicule_id'=> $request->vehicule,
                        'conducteur_id'=> $request->conducteur,
                        'DetailsPanne'=> $request->detailpane,
                        'Status'=> $request->status,
                        'user_id'=> Auth::user()->id,
                        // 'user_id'=> Auth::user()->id,
               ]);
           }elseif($request->panne == 'REPARE'){

            $lastReference = Versements::whereYear('created_at', $currentYear) 
                                        ->whereMonth('created_at', $currentMonth) 
                                        ->orderBy('id', 'desc')->first();

            $maxId = $lastReference ? $lastReference->id: 0;
            $maxId++; 
            $reference = sprintf('%d-%02d-%04d', $currentYear, $currentMonth, $maxId);
           

            if($reparer->CoutReparation)
            {
            $modivers = Versements::where('Reference', $reparer->Reference)->first();
            $modivers->update(['Montant'=> $request->coutRepar,'user_id'=> Auth::user()->id, ]);
            }else{

            Versements::create([
                'Montant'=> $request->coutRepar,
                'MoyenPaiemet'=> 'ESPECE',
                'Reference'=> $reparer->Reference,
                'Rubrique'=> 'REPARATION VEHICULE',
                'date'=> $request->dateRepar,
                'Mouvement'=> 'SORTIE DE CAISSE',
                'Type'=> 'employe',
                'conducteur_id'=> $reparer->conducteur_id,
                'vehicule_id'=> $reparer->vehicule_id,
                'codePaiement'=> $reference,
                'user_id'=> Auth::user()->id,
                ]);
            }
            $reparer->update([
                'typeReparation'=> $request->typeRepar,
                'CoutReparation'=> $request->coutRepar,
                'DateReparation'=> $request->dateRepar,
                'DetailsReparation'=> $request->detailrepar,
                'Status'=> $request->status,
                'user_id'=> Auth::user()->id,
            ]);

                
           }

           return redirect()->back()->with('success', "la modification a été effectué avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=Reparations::findOrFail($id);
        $delet->update(['supprimer'=> 1, 'Active'=>0 ]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");
    }

    public function pannevehicule($id)
    {
        $pannes=Reparations::where('supprimer', 0)
                            ->where('vehicule_id', $id)
                            ->OrderBy('id', 'DESC')
                            ->get();
        $conducteurs=Conducteurs::WHERE('supprimer', 0)->get();
        $idvehicule=$id;

        $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)
        ->where('Status', 'ASSIGNE')
        ->OrderBy('id', 'DESC')
        ->first();

    return view('vehicules.reparation_pannes')->with([
        'pannes'=>$pannes,'idvehicule'=>$idvehicule,'conducteurs'=>$conducteurs,
        'chauferVehicules'=>$chauferVehicules,
    ]);
    }
}
