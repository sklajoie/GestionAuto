<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visites;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\VehiculeConducteurs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class VisitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visites = Visites::where('supprimer', 0)->OrderBy('id','DESC')->get();
        $chauferVehicules= VehiculeConducteurs::where('Status', 'ASSIGNE')
                                                ->OrderBy('id', 'DESC')
                                                ->first();
        return view('visites.index')->with([
            'visites'=>$visites,'chauferVehicules'=>$chauferVehicules,
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
            'date_vit' => 'required',
            'date_fin_vit' => 'required',
           ]);

           $id=$request->idvehecule;

           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;
            

           $grandnumg=Visites::max('id');
           $Newnumero = $grandnumg +1;
                       if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'VS000'.$Newnumero ;}
                       elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'VS00'.$Newnumero ;} 
                       elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'VS0'.$Newnumero ;} 
                       else{$Newnumero = 'VS'.$Newnumero ;}

                       
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
                    'Montant'=> $request->montant,
                    'Status'=> "EN COURS",
                    'user_id'=> Auth::user()->id,
                   'Reference'=> $Newnumero,
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
                        'Rubrique'=> 'VISITE TECHNIQUE',
                        'date'=> $request->date_vit,
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
                    'Montant'=> $request->montant,
                    'user_id'=> Auth::user()->id,
           ]);

           
           if($modifvisit->Reference)
           {
           $modivers = Versements::where('Reference', $modifvisit->Reference)->first();
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
     * @param  \App\Models\Visites  $visites
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=Visites::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");

    }
}
