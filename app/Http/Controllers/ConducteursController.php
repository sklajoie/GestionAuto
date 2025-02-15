<?php

namespace App\Http\Controllers;

use App\Models\Conducteurs;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class ConducteursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chauffeurs=Conducteurs::WHERE('supprimer', 0)->get();
        return view('conducteurs.index')->with([
            'chauffeurs'=>$chauffeurs,
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
            'nomPrenom' => 'required',
            'contact' => 'required',
           ]);

           $grandnumg=Conducteurs::max('id');
            $Newnumero = $grandnumg +1;
                        if ((strlen((string)$Newnumero) == 1)) { $Newnumero = 'C000'.$Newnumero ;}
                        elseif ((strlen((string)$Newnumero) == 2)) { $Newnumero = 'C00'.$Newnumero ;} 
                        elseif ((strlen((string)$Newnumero) == 3)) { $Newnumero = 'C0'.$Newnumero ;} 
                        else{$Newnumero = 'C'.$Newnumero ;}
          
        if($request->permis !=null){
        $imageTempName = $request->file('permis')->getPathname();
        $imageName = $request->file('permis')->getClientOriginalName();
        $path = base_path() . '/public/images/pieceConducteur/';
        $request->file('permis')->move($path , $imageName); 

        }else{
            $imageName =null;
        }

           try { 
           Conducteurs::create([
                    'NomPrenom'=> $request->nomPrenom,
                    'Contact'=> $request->contact,
                    'Email'=> $request->email,
                    'Address'=> $request->address,
                    'Reference'=> $Newnumero,
                    'Permis'=> $imageName,
                    'Status'=> $request->status,
                    'Active'=> 1,
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
        //
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
            'nomPrenom' => 'required',
            'contact' => 'required',
           ]);

           
          
        if($request->permis !=null){
        $imageTempName = $request->file('permis')->getPathname();
        $imageName = $request->file('permis')->getClientOriginalName();
        $path = base_path() . '/public/images/pieceConducteur/';
        $request->file('permis')->move($path , $imageName); 

        }else{
            $imageName =null;
        }

           try { 
            $modifconduct=Conducteurs::findOrFail($id);
            if($imageName !=null)
            {

          
            $modifconduct->update([
                    'NomPrenom'=> $request->nomPrenom,
                    'Contact'=> $request->contact,
                    'Email'=> $request->email,
                    'Address'=> $request->address,
                    'Permis'=> $imageName,
                    'Status'=> $request->status,
                    'user_id'=> Auth::user()->id,
           ]);
        }else{
            $modifconduct->update([
                'NomPrenom'=> $request->nomPrenom,
                'Contact'=> $request->contact,
                'Email'=> $request->email,
                'Address'=> $request->address,
                'Status'=> $request->status,
                'user_id'=> Auth::user()->id,
       ]);
        }
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->with('danger', "Les données enregistrements ne sont pas correctes merci de verrifier !!! "); 
          }

    return redirect()->back()->with('success', "l'Enregistrement a été effectué avec success");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deletVehicule=Conducteurs::findOrFail($id);
        $deletVehicule->update(['supprimer'=> 1, 'Active'=>0 ]);

        return redirect()->back()->with('success', "l'Enregistrement a été Supprimé avec success");
    }
}
