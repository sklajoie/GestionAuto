<?php

namespace App\Http\Controllers;

use App\Models\Conducteurs;
use Carbon\Carbon;
use App\Models\Ressources;
use App\Models\VehiculeConducteurs;
use App\Models\Versements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $versements= Versements::where('supprimer', 0)->OrderBy('id','DESC')->get();

        return view('versements.index')->with([
            'versements'=>$versements,
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
            'beneficiare' => 'required',
            'montant' => 'required',
            'type_benef' => 'required',
           ]);
           $employe=null; $beneficiare=null;

           
           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;

           $lastReference = Versements::whereYear('created_at', $currentYear) 
                                            ->whereMonth('created_at', $currentMonth) 
                                            ->orderBy('id', 'desc') ->first();

            $maxId = $lastReference ? $lastReference->id: 0;
             $maxId++; 
             $reference = sprintf('%d-%02d-%04d', $currentYear, $currentMonth, $maxId);
            //dd($reference);

           if($request->type_benef == "employe"){
            $employe=$request->beneficiare;
           }elseif($request->type_benef == "autre")
           {$beneficiare=$request->beneficiare;}
            
           $newmontant=0; $numm=null;
            if($request->nummobile !=null){
                $numm=$request->nummobile;
            }elseif($request->banque !=null || $request->cheque !=null  ){
                    $numm= $request->banque."/".$request->cheque;
            }

            if( !empty($request->decharge))
                    {
                 $imageTempName = $request->file('decharge')->getPathname();
				$imageName = $request->file('decharge')->getClientOriginalName();
                $newImageName = time() . '_' . $imageName;
				$path = 'images/Decharge/';
				$request->file('decharge')->move($path , $newImageName); 
                    }else{$newImageName = null;}

                    if($request->paiement == null){
                        $modepaiement="ESPECE";
                        }else{$modepaiement=$request->paiement;}

            Versements::create([
                   'Montant'=> $request->montant,
                    'MoyenPaiemet'=> $modepaiement,
                    'Reference'=> $numm,
                    'Details'=> $request->commentaire,
                    'Rubrique'=> $request->nature_mouvement,
                    'pieceJointe'=> $newImageName,
                    'date'=> $request->date,
                    'Beneficier'=> $beneficiare,
                    'Mouvement'=> $request->type_mouvement,
                    'Type'=> $request->type_benef,
                    'conducteur_id'=> $employe,
                    'vehicule_id'=> $request->idvehicule,
                    'codePaiement'=> $reference,
                    'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été effectué avec success");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $versements= Versements::where('vehicule_id', $id)->OrderBy('id', 'DESC')->get();
        $idvehicule=$id;
        $chauferVehicules= VehiculeConducteurs::WHERE('vehicule_id', $id)
                                                ->where('Status', 'ASSIGNE')
                                                ->OrderBy('id', 'DESC')
                                                ->first();

        $conducteurs=Conducteurs::WHERE('supprimer', 0)->get();
    return view('vehicules.versement_vehicules')->with([
        'versements'=>$versements,'idvehicule'=>$idvehicule,
        'conducteurs'=>$conducteurs,'chauferVehicules'=>$chauferVehicules,
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
        $versements = Versements::where('id', $id)->first();
        return view('versements.edit')->with([
            'versements'=>$versements,
        ]);
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
            // 'beneficiare' => 'required',
            'montant' => 'required',
            // 'type_benef' => 'required',
           ]);
           $idvoiture=null; $idconducteur=null;
           $modifvers=Versements::findOrFail($id);

           $employe=null; $beneficiare=null;

           if($request->type_benef == "employe"){
            $employe=$request->beneficiare;
           }elseif($request->type_benef == "autre")
           {$beneficiare=$request->beneficiare;}
            
           $newmontant=0; $numm=null;
            if($request->nummobile !=null){
                $numm=$request->nummobile;
            }elseif($request->banque !=null || $request->cheque !=null  ){
                    $numm= $request->banque."/".$request->cheque;
            }else{$numm=$modifvers->Reference;}

            ;

            if( !empty($request->decharge))
                    {
                 $imageTempName = $request->file('decharge')->getPathname();
				$imageName = $request->file('decharge')->getClientOriginalName();
                $newImageName = time() . '_' . $imageName;
				$path = 'images/Decharge/';
				$request->file('decharge')->move($path , $newImageName); 
                    }else{$newImageName = $modifvers->pieceJointe;}

                    if($request->paiement == null){
                        $modepaiement="CASH";
                        }else{$modepaiement=$request->paiement;}
       
        $modifvers->update([
                    'Montant'=> $request->montant,
                    'MoyenPaiemet'=> $modepaiement,
                    'Reference'=> $numm,
                    'Details'=> $request->commentaire,
                    'Rubrique'=> $request->nature_mouvement,
                    'pieceJointe'=> $newImageName,
                    'date'=> $request->date,
                    'Beneficier'=> $beneficiare,
                    'Mouvement'=> $request->type_mouvement,
                    'Type'=> $request->type_benef,
                    'conducteur_id'=> $employe,
                    'vehicule_id'=> $request->idvehicule,
                    'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été modifié avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=Versements::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");

    }
    public function recherchetypemvmt($id)
    {
        $typ=$id;
       
          $data['data']= Ressources::WHERE('Autre',"$typ")->get();

       return response()->json($data);
       
    }
}
