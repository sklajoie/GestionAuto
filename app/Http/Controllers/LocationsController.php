<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations= Locations::All();

        return view('locations.index')->with([
            'locations'=>$locations,
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
            'nomclient' => 'required',
            'telclient' => 'required',
            'datedebut' => 'required',
           ]);

           
           if($request->piece !=null){
            $imageTempName = $request->file('piece')->getPathname();
            $imageName = $request->file('piece')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/locations/';
            $request->file('piece')->move($path , $newImageName); 
    
            }else{
                $newImageName =null;
            }
            
            Locations::create([
                   'Details'=> $request->details,
                    'Client'=> $request->nomclient,
                    'Contact'=> $request->telclient,
                    'Address'=> $request->addressclient,
                    'DateDebut'=> $request->datedebut,
                    'DateFin'=> $request->datefin,
                    'Montant'=> $request->prix,
                    'KmDebut'=> $request->kmdebut,
                    'KmFin'=> $request->kmfin,
                    'Status'=> 'EN ATTENTE',
                    'Piece'=> $newImageName,
                    'vehicule_id'=> $request->vehicule,
                    'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été effectué avec success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function show(Locations $locations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function edit(Locations $locations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'nomclient' => 'required',
            'telclient' => 'required',
            'datedebut' => 'required',
           ]);

           $modiflocal = Locations::findOrFail($id);
           
           if($request->piece !=null){
            $imageTempName = $request->file('piece')->getPathname();
            $imageName = $request->file('piece')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/locations/';
            $request->file('piece')->move($path , $newImageName); 
    
            }else{
                $newImageName =$modiflocal->Piece;
            }
            
            // $modiflocal = Locations::findOrFail($id);
            $modiflocal->update([
                   'Details'=> $request->details,
                    'Client'=> $request->nomclient,
                    'Contact'=> $request->telclient,
                    'Address'=> $request->addressclient,
                    'DateDebut'=> $request->datedebut,
                    'DateFin'=> $request->datefin,
                    'Montant'=> $request->prix,
                    'KmDebut'=> $request->kmdebut,
                    'KmFin'=> $request->kmfin,
                    'Piece'=> $newImageName,
                    'vehicule_id'=> $request->vehicule,
                    'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été modifié avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Locations $locations)
    {
        //
    }
}
