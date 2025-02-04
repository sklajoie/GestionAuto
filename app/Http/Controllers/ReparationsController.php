<?php

namespace App\Http\Controllers;

use App\Models\Vehicules;
use App\Models\Conducteurs;
use App\Models\Reparations;
use App\Models\VehiculeConducteurs;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ReparationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pannes=Reparations::WHERE('supprimer', 0)->get();
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
                    // 'user_id'=> Auth::user()->id,
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
        //
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
