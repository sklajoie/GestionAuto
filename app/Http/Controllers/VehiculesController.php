<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Visites;
use App\Models\Vidanges;
use App\Models\Vehicules;
use App\Models\Assurances;
use App\Models\Versements;
use App\Models\Conducteurs;
use App\Models\Reparations;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VehiculesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicules=Vehicules::where('supprimer', 0)->get();

        
        ///dd($vehicules->assurance);


        return view('vehicules.index')->with([
            'vehicules'=>$vehicules,
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
            'matricule' => 'required','unique:vehicules',
            'marque' => 'required',
            'model' => 'required',
            'dateacq' => 'required',
           ]);

           try { 
           Vehicules::create([
                    'Type'=> $request->type,
                    'Matriculation'=> $request->matricule,
                    'Marque'=> $request->marque,
                    'Model'=> $request->model,
                    'Chassis'=> $request->numChassi,
                    'NombrePlace'=> $request->Nplace,
                    'DateAcquisition'=> $request->dateacq,
                    'Couleur'=> $request->couleur,
                    'Carburant'=> $request->carburant,
                    'Categorie'=> $request->categorie,
                    'Active'=> 1,
                    'Status'=> $request->status,
                    'user_id'=> Auth::user()->id,
                    // 'user_id'=> Auth::user()->id,
           ]);
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->withErrors($request->all())->withInput()->with('danger', "Les données enregistrements ne sont pas correctes ou l'immatriculation du véhicule existe déja merci de verrifier !!! "); 
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
        $vehicules= Vehicules::where('id', $id)->first();

        $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
        // dd($chauferVehicules);
        $conducteurs=Conducteurs::WHERE('supprimer', 0)->get();
        $vehiculesl=Vehicules::WHERE('supprimer', 0)->get();
        
        $pannes=Reparations::where('supprimer', 0)->where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();

        $versements= Versements::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
        $assurances = Assurances::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
        $visites = Visites::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
        $vidanges = Vidanges::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();


        return view('vehicules.details')->with([
            'vehicules'=>$vehicules,'chauferVehicules'=>$chauferVehicules,
            'conducteurs'=>$conducteurs,'vehiculesl'=>$vehiculesl,'pannes'=>$pannes,
            'versements'=>$versements,'assurances'=>$assurances,'visites'=>$visites,
            'vidanges'=>$vidanges,
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
        $this->validate($request,[
            'matricule' => 'required',
            'marque' => 'required',
            'model' => 'required',
            'dateacq' => 'required',
           ]);

           try { 
            $modifvehicule=Vehicules::findOrFail($id);
            $modifvehicule->update([
                'Type'=> $request->type,
                     'Matriculation'=> $request->matricule,
                    'Marque'=> $request->marque,
                    'Model'=> $request->model,
                    'Chassis'=> $request->numChassi,
                    'NombrePlace'=> $request->Nplace,
                    'DateAcquisition'=> $request->dateacq,
                    'Couleur'=> $request->couleur,
                    'Carburant'=> $request->carburant,
                    'Categorie'=> $request->categorie,
                    'Active'=> 0,
                    'Status'=> $request->status,
                    'user_id'=> Auth::user()->id,
           ]);
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->with('danger', "Les données enregistrements ne sont pas correctes ou l'immatriculation du véhicule existe déja merci de verrifier !!! "); 
          }

    return redirect()->back()->with('success', "l'Enregistrement a été modifié avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletVehicule=Vehicules::findOrFail($id);
        $deletVehicule->update(['supprimer'=> 1, 'Active'=>0 ]);
    }

    public function getvehicule()
    {
        $vehicules=Vehicules::WHERE('supprimer', 0)->get();

        foreach($vehicules as $vehicule)
        {
            $countAssura = Assurances::where('Etat', 0)
                                        // ->where('DateFin', '<=', date("Y-m-d", strtotime("+2 month")))
                                          ->where('vehicule_id', $vehicule->id)
                                         ->get();

            $countVisite = Visites::where('Etat', 0)
                                        // ->where('DateFin', '<=', date("Y-m-d", strtotime("+8 month")))
                                          ->where('vehicule_id', $vehicule->id)
                                         ->get();
       
                
                
        }
       // dd($countAssura);


        return view('vehicules.vehicules')->with([
            'vehicules'=>$vehicules,
        ]);
    }

}
