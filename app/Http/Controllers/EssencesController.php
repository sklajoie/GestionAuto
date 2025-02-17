<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Essences;
use App\Models\Versements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EssencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $essences = Essences::where('supprimer', 0)->OrderBy('id','DESC')->get();

        return view('essences.index')->with([
            'essences'=>$essences,
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
            'vehicule' => 'required',
            'prixlitre' => 'required',
            'date' => 'required',
           ]);
           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;
            

           $grandnumg=Essences::max('id');
           $Newnumero = $grandnumg +1;
                       if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'ES000'.$Newnumero ;}
                       elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'ES00'.$Newnumero ;} 
                       elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'ES0'.$Newnumero ;} 
                       else{$Newnumero = 'ES'.$Newnumero ;}

            Essences::create([
                   'PrixLitre'=> $request->prixlitre,
                    'Montant'=> $request->montant,
                    'QTELitre'=> $request->qtelitre,
                    'KmgDebut'=> $request->kmgdebut,
                    'KmgFin'=> $request->kmgfin,
                    'Date'=> $request->date,
                    'Description'=> $request->description,
                    'conducteur_id'=> $request->conducteur,
                    'Status'=> 'EN ATTENTE',
                    'vehicule_id'=> $request->vehicule,
                    'Reference'=> $Newnumero,
                    'user_id'=> Auth::user()->id,
           ]);

           
           if($request->montant)
           {

       
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
             'Rubrique'=> 'PRISE DE CARBURANT',
             'date'=> $request->date,
             'Mouvement'=> 'SORTIE DE CAISSE',
             'Type'=> 'employe',
             'conducteur_id'=> $request->conducteur,
             'vehicule_id'=> $request->vehicule,
             'codePaiement'=> $reference,
             'user_id'=> Auth::user()->id,
    ]);

           }
           
    return back()->with('success', "l'Enregistrement a été effectué avec success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Essences  $essences
     * @return \Illuminate\Http\Response
     */
    public function show(Essences $essences)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Essences  $essences
     * @return \Illuminate\Http\Response
     */
    public function edit(Essences $essences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Essences  $essences
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'vehicule' => 'required',
            'prixlitre' => 'required',
            'date' => 'required',
           ]);

            
            $modifess = Essences::findOrFail($id);
            $modifess->update([
                   'PrixLitre'=> $request->prixlitre,
                    'Montant'=> $request->montant,
                    'QTELitre'=> $request->qtelitre,
                    'KmgDebut'=> $request->kmgdebut,
                    'KmgFin'=> $request->kmgfin,
                    'Date'=> $request->date,
                    'Description'=> $request->description,
                    'conducteur_id'=> $request->conducteur,
                    'vehicule_id'=> $request->vehicule,
                    'user_id'=> Auth::user()->id,
           ]);
           if($modifess->Reference)
           {
           $modivers = Versements::where('Reference', $modifess->Reference)->first();
           $modivers->update(['Montant'=> $request->montant,'user_id'=> Auth::user()->id, ]);
           }

    return back()->with('success', "l'Enregistrement a été modifié avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Essences  $essences
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=Essences::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");
    }
}
