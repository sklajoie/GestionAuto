<?php

namespace App\Http\Controllers;

use App\Models\Assurances;
use App\Models\VehiculeConducteurs;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssurancesController extends Controller
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
            'date_debut' => 'required',
            'date_fin' => 'required',
           ]);
                    $id=$request->idvehecule;
           if($request->photo_assur !=null){
            $imageTempName = $request->file('photo_assur')->getPathname();
            $imageName = $request->file('photo_assur')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/assurances/';
            $request->file('photo_assur')->move($path , $newImageName); 
    
            }else{
                $newImageName =null;
            }

           try { 
            $modifassur=Assurances::where('vehicule_id', $id)->OrderBy('id', 'DESC')->first();
            if($modifassur){  $modifassur->update(['Etat'=>1, 'Status'=> "FIN",'user_id'=> Auth::user()->id,]); }
           Assurances::create([
                    'NomAssurance'=> $request->num_assur,
                    'CompagnieAssurance'=> $request->comp_assur,
                    'DateDebut'=> $request->date_debut,
                    'DateFin'=> $request->date_fin,
                    'vehicule_id'=> $request->idvehecule,
                    'conducteur_id'=> $request->conducteur,
                    'Attestation'=> $newImageName,
                    'Details'=> $request->details,
                    'Status'=> "EN COURS",
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
     * @param  \App\Models\Assurances  $assurances
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $assurances = Assurances::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
            $idvehicule=$id;
            $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)
            ->where('Status', 'ASSIGNE')
            ->OrderBy('id', 'DESC')
            ->first();
        return view('vehicules.assurance')->with([
            'assurances'=>$assurances,'idvehicule'=>$idvehicule,
            'chauferVehicules'=>$chauferVehicules,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assurances  $assurances
     * @return \Illuminate\Http\Response
     */
    public function edit(Assurances $assurances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assurances  $assurances
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date_debut' => 'required',
            'date_fin' => 'required',
           ]);

          

           try { 
            $modifassur=Assurances::findOrFail($id);
            $modifassur->update([
                    'NomAssurance'=> $request->num_assur,
                    'CompagnieAssurance'=> $request->comp_assur,
                    'DateDebut'=> $request->date_debut,
                    'DateFin'=> $request->date_fin,
                    'conducteur_id'=> $request->conducteur,
                    'Details'=> $request->details,
                    'user_id'=> Auth::user()->id,
           ]);
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->withErrors($request->all())->withInput()->with('danger', "Les données enregistrements ne sont pas correctes merci de verrifier !!! "); 
          }

    return redirect()->back()->with('success', "l'Enregistrement a été effectué avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assurances  $assurances
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assurances $assurances)
    {
        //
    }
}
