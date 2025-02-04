<?php

namespace App\Http\Controllers;

use App\Models\Ressources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ressources= Ressources::all();
        return view('ressource.index')->with([
            'ressources'=>$ressources,
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
            'type' => 'required',
            'rubrique' => 'required',
           ]);

            
            Ressources::create([
                   'Rubrique'=> $request->rubrique,
                    'Autre'=> $request->type,
                    'user_id'=> 1
                    // 'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été effectué avec success");
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ressources  $ressources
     * @return \Illuminate\Http\Response
     */
    public function show(Ressources $ressources)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ressources  $ressources
     * @return \Illuminate\Http\Response
     */
    public function edit(Ressources $ressources)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ressources  $ressources
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'type' => 'required',
            'rubrique' => 'required',
           ]);

            $modif=Ressources::findOrFail($id);
            $modif->update([
                    'Rubrique'=> $request->rubrique,
                    'Autre'=> $request->type,
                    'user_id'=> 1
                    // 'user_id'=> Auth::user()->id,
           ]);

    return back()->with('success', "l'Enregistrement a été effectué avec success");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ressources  $ressources
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ressources $ressources)
    {
        //
    }
}
