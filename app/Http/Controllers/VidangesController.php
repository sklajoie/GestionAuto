<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vidanges;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VidangesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vidanges = Vidanges::where('supprimer', 0)->OrderBy('id','DESC')->get();
        $chauferVehicules= VehiculeConducteurs::where('Status', 'ASSIGNE')
                                                ->OrderBy('id', 'DESC')
                                                ->first();
        return view('vidanges.index')->with([
            'vidanges'=>$vidanges,'chauferVehicules'=>$chauferVehicules,
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
            'date_vidange' => 'required',
            'kilo_vidange' => 'required',
           ]);

           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;
            

           $grandnumg=Vidanges::max('id');
           $Newnumero = $grandnumg +1;
                       if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'VD000'.$Newnumero ;}
                       elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'VD00'.$Newnumero ;} 
                       elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'VD0'.$Newnumero ;} 
                       else{$Newnumero = 'VD'.$Newnumero ;}

          
            $id=$request->idvehecule;
           try { 

            $modif=Vidanges::where('vehicule_id', $id)->OrderBy('id', 'DESC')->first();
            if($modif){ $modif->update(['Etat'=>1, 'Status'=> "FIN",'user_id'=> Auth::user()->id,]);}
           

           Vidanges::create([
                    'DateVidange'=> $request->date_vidange,
                    'DateFin'=> $request->date_fin,
                    'KiloVidange'=> $request->kilo_vidange,
                    'MarqueHuile'=> $request->marque_huile,
                    'KiloHuile'=> $request->kilo_huile,
                    'KiloProchainVidange'=> $request->kilo_prochain,
                    'vehicule_id'=> $request->idvehecule,
                    'conducteur_id'=> $request->conducteur,
                    'Details'=> $request->details,
                    'Montant'=> $request->montant,
                    'Status'=> "EN COURS",
                    'Reference'=> $Newnumero,
                    'user_id'=> Auth::user()->id,
           ]);

           $lastReference = Versements::whereYear('created_at', $currentYear) 
                                        ->whereMonth('created_at', $currentMonth) 
                                        ->orderBy('id', 'desc')->first();

                $maxId = $lastReference ? $lastReference->id: 0;
                $maxId++; 
                $reference = sprintf('%d-%02d-%04d', $currentYear, $currentMonth, $maxId);

                Versements::create([
                        'Montant'=> $request->montant,
                        'MoyenPaiemet'=> 'ESPECE',
                        'Reference'=> $Newnumero,
                        'Rubrique'=> 'VIDANGE VEHICULE',
                        'date'=> $request->date_vidange,
                        'Mouvement'=> 'SORTIE DE CAISSE',
                        'Type'=> 'employe',
                        'conducteur_id'=> $request->conducteur,
                        'vehicule_id'=> $request->idvehecule,
                        'codePaiement'=> $reference,
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
     * @param  \App\Models\Vidanges  $vidanges
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vidanges = Vidanges::where('vehicule_id', $id)->get();
        $idvehicule=$id;
        $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)
        ->where('Status', 'ASSIGNE')
        ->OrderBy('id', 'DESC')
        ->first();
    return view('vehicules.vidanges')->with([
        'vidanges'=>$vidanges,'idvehicule'=>$idvehicule,'chauferVehicules'=>$chauferVehicules,
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vidanges  $vidanges
     * @return \Illuminate\Http\Response
     */
    public function edit(Vidanges $vidanges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vidanges  $vidanges
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date_vidange' => 'required',
            'kilo_vidange' => 'required',
           ]);

          

           try { 
          $vidanges= Vidanges::findOrFail($id);
          $vidanges->update([
                    'DateVidange'=> $request->date_vidange,
                    'DateFin'=> $request->date_fin,
                    'KiloVidange'=> $request->kilo_vidange,
                    'MarqueHuile'=> $request->marque_huile,
                    'KiloHuile'=> $request->kilo_huile,
                    'KiloProchainVidange'=> $request->kilo_prochain,
                    'conducteur_id'=> $request->conducteur,
                    'Details'=> $request->details,
                    'Montant'=> $request->montant,
                    'user_id'=> Auth::user()->id,
           ]);

           if($vidanges->Reference)
           {
           $modivers = Versements::where('Reference', $vidanges->Reference)->first();
           $modivers->update(['Montant'=> $request->montant,'user_id'=> Auth::user()->id, ]);
           }
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->withErrors($request->all())->withInput()->with('danger', "Les données enregistrements ne sont pas correctes merci de verrifier !!! "); 
          }

    return redirect()->back()->with('success', "l'Enregistrement a été modifié avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vidanges  $vidanges
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=Vidanges::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");

    }
}
