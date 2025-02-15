<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Locations;
use App\Models\Versements;
use Illuminate\Http\Request;
use App\Models\VersementLocation;
use App\Models\ConducteurLocation;
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
        $locations= Locations::where('supprimer', 0)->get();

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

           
            

           $grandnumg=Locations::max('id');
           $Newnumero = $grandnumg +1;
                       if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'LV000'.$Newnumero ;}
                       elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'LV00'.$Newnumero ;} 
                       elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'LV0'.$Newnumero ;} 
                       else{$Newnumero = 'ES'.$Newnumero ;}

                       
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
                    'Reference'=> $Newnumero,
           ]);

    return back()->with('success', "l'Enregistrement a été effectué avec success");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Locations  $locations
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locations= Locations::where('id', $id)->first();
        $chauffeurs= ConducteurLocation::where('location_id', $id)->get();
        $versements= VersementLocation::where('location_id', $id)->get();
       

        return view('locations.details')->with([
            'locations'=>$locations,'chauffeurs'=>$chauffeurs,'versements'=>$versements,
        ]);
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
    public function destroy($id)
    {
        $delet=Locations::findOrFail($id);
        $delet->update(['supprimer'=> 1]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");
    }

    public function postConducteurlocation(Request $request)
    {
        $this->validate($request,[
            'location' => 'required',
            'date' => 'required',
            'conducteur' => 'required',
           ]);


        ConducteurLocation::create([
            'location_id'=> $request->location,
             'Date'=> $request->date,
             'conducteur_id'=> $request->conducteur,
             'user_id'=> Auth::user()->id,
    ]);
    return back()->with('success', "l'Enregistrement a été modifié avec success");
    }
    public function postversementlocation(Request $request)
    {
        $this->validate($request,[
            'montant' => 'required',
            'date' => 'required',
            'location' => 'required',
           ]);

           $currentYear = Carbon::now()->year;
           $currentMonth = Carbon::now()->month;

           $lastRef = VersementLocation::whereYear('created_at', $currentYear) 
                                    ->whereMonth('created_at', $currentMonth) 
                                    ->orderBy('id', 'desc')->first();

            $maxId = $lastRef ? $lastRef->id: 0;
            $maxId++; 
            $referencevl = sprintf('%d-%02d-%04d', $currentYear, $currentMonth, $maxId);

        VersementLocation::create([
            'Reference'=> $referencevl,
            'Montant'=> $request->montant,
            'location_id'=> $request->location,
             'Date'=> $request->date,
             'MoyenPaiemet'=> $request->moyen,
             'user_id'=> Auth::user()->id,
    ]);
            $locatn=Locations::where('id',$request->location)->first();
           
            $lastReference = Versements::whereYear('created_at', $currentYear) 
                                ->whereMonth('created_at', $currentMonth) 
                                ->orderBy('id', 'desc')->first();

            $maxId = $lastReference ? $lastReference->id: 0;
            $maxId++; 
            $reference = sprintf('%d-%02d-%04d', $currentYear, $currentMonth, $maxId);

            Versements::create([
            'Montant'=> $request->montant,
            'MoyenPaiemet'=> $request->moyen,
            'Reference'=> $referencevl,
            'Rubrique'=> 'VERSEMENT LOCATION',
            'date'=> $request->date,
            'Mouvement'=> 'ENTREE EN CAISSE',
            'Type'=> 'autre',
            'vehicule_id'=> $locatn->vehicule_id,
            'Beneficier'=> $locatn->Client,
            'codePaiement'=> $reference,
            'user_id'=> Auth::user()->id,
            ]);


    return back()->with('success', "l'Enregistrement a été modifié avec success");
    }



}
