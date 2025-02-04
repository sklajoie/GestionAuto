<?php

namespace App\Http\Controllers;

use App\Models\VehiculeConducteurs;
use App\Models\Visites;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitesController extends Controller
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
            'date_vit' => 'required',
            'date_fin_vit' => 'required',
           ]);

           $id=$request->idvehecule;

           if($request->foto_cert !=null){
            $imageTempName = $request->file('foto_cert')->getPathname();
            $imageName = $request->file('foto_cert')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/visites/';
            $request->file('foto_cert')->move($path , $newImageName); 
    
            }else{
                $newImageName =null;
            }

           try { 

            $modif=Visites::where('vehicule_id', $id)->OrderBy('id', 'DESC')->first();
            if($modif){$modif->update(['Etat'=>1, 'Status'=> "FIN",'user_id'=> Auth::user()->id,]);}

           Visites::create([
                    'DateVisite'=> $request->date_vit,
                    'DateFin'=> $request->date_fin_vit,
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
     * @param  \App\Models\Visites  $visites
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visites = Visites::where('vehicule_id', $id)->get();
        $idvehicule=$id;
        $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)
        ->where('Status', 'ASSIGNE')
        ->OrderBy('id', 'DESC')
        ->first();
        
    return view('vehicules.visites')->with([
        'visites'=>$visites,'idvehicule'=>$idvehicule,
        'chauferVehicules'=>$chauferVehicules,
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visites  $visites
     * @return \Illuminate\Http\Response
     */
    public function edit(Visites $visites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visites  $visites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date_vit' => 'required',
            'date_fin_vit' => 'required',
           ]);
           
           $modifvisit=Visites::findOrFail($id);

           if($request->foto_cert !=null){
            $imageTempName = $request->file('foto_cert')->getPathname();
            $imageName = $request->file('foto_cert')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/visites/';
            $request->file('foto_cert')->move($path , $newImageName); 
    
            }else{
                $newImageName = $modifvisit->Attestation;
            }

           try { 
           $modifvisit->update([
                    'DateVisite'=> $request->date_vit,
                    'DateFin'=> $request->date_fin_vit,
                    'conducteur_id'=> $request->conducteur,
                    'Attestation'=> $newImageName,
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
     * @param  \App\Models\Visites  $visites
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visites $visites)
    {
        //
    }
}
