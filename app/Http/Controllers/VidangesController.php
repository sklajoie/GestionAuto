<?php

namespace App\Http\Controllers;

use App\Models\VehiculeConducteurs;
use App\Models\Vidanges;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VidangesController extends Controller
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
            'date_vidange' => 'required',
            'kilo_vidange' => 'required',
           ]);

          
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
                    'Status'=> "EN COURS",
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
                    'user_id'=> Auth::user()->id,
                    // 'user_id'=> Auth::user()->id,
           ]);
           
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
    public function destroy(Vidanges $vidanges)
    {
        //
    }
}
