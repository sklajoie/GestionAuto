<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Assurances;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AssurancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assurances = Assurances::where('supprimer', 0)->OrderBy('id','DESC')->get();
        $chauferVehicules= VehiculeConducteurs::where('Status', 'ASSIGNE')
                                                ->OrderBy('id', 'DESC')
                                                ->first();
        return view('assurances.index')->with([
            'assurances'=>$assurances,'chauferVehicules'=>$chauferVehicules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
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

            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;
                
    
            $grandnumg=Assurances::max('id');
            $Newnumero = $grandnumg +1;
                        if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'VS000'.$Newnumero ;}
                        elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'VS00'.$Newnumero ;} 
                        elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'VS0'.$Newnumero ;} 
                        else{$Newnumero = 'VS'.$Newnumero ;}
    
                
                                
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
                    'Montant'=> $request->montant,
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
                        'Rubrique'=> 'RENOUVELLEMENT ASSURANCE',
                        'date'=> $request->date_debut,
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

          
           $modifassur=Assurances::findOrFail($id);

           if($request->photo_assur !=null){
            $imageTempName = $request->file('photo_assur')->getPathname();
            $imageName = $request->file('photo_assur')->getClientOriginalName();
            $newImageName = time() . '_' . $imageName;
            $path = base_path() . '/public/images/assurances/';
            $request->file('photo_assur')->move($path , $newImageName); 
    
            }else{
                $newImageName =$modifassur->Attestation;
            }

           try { 
           
            $modifassur->update([
                    'NomAssurance'=> $request->num_assur,
                    'CompagnieAssurance'=> $request->comp_assur,
                    'DateDebut'=> $request->date_debut,
                    'DateFin'=> $request->date_fin,
                    'conducteur_id'=> $request->conducteur,
                    'Details'=> $request->details,
                    'Montant'=> $request->montant,
                    'Attestation'=> $newImageName,
                    'user_id'=> Auth::user()->id,
           ]);

           if($modifassur->Reference)
           {
           $modivers = Versements::where('Reference', $modifassur->Reference)->first();
           $modivers->update(['Montant'=> $request->montant,'user_id'=> Auth::user()->id, ]);
           }
           
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
    public function destroy($id)
    {
        $delet=Assurances::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");
    }
}
