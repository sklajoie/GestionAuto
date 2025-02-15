<?php

namespace App\Http\Controllers;

use App\Models\Connexionusers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::WHERE('supprimer', 0)->get();             
            return view("users.index")->with([
             "users"=>$users,
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
            'nom' => 'required',
            'pass' => 'required',
            'tel' => 'required',
           ]);

           //dd($request->all());
           try { 

           User::create([
                    'name'=> $request->nom,
                    'email'=> $request->email,
                    'Contact'=> $request->tel,
                    'Fonction'=> $request->fonction,
                    'password'=> Hash::make($request->pass),
                    'Active'=> 1,
           ]);
           
        } catch(QueryException $ex){ 
            // dd($ex->getMessage());
            return back()->withErrors($request->all())->withInput()->with( 'danger', "Les données enregistrements ne sont pas correctes merci de verrifier !!! "); 
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
            'nom' => 'required',
            'pass' => 'required',
            'tel' => 'required',
           ]);


           try { 
            $modif= User::findOrFail($id);
            if($request->pass)
            {

                $modif->update([
                        'name'=> $request->nom,
                        'email'=> $request->tel,
                        'Contact'=> $request->email,
                        'Fonction'=> $request->fonction,
                        'password'=> Hash::make($request->pass),
                    ]);
                }else{
                $modif->update([
                        'name'=> $request->nom,
                        'email'=> $request->tel,
                        'Contact'=> $request->email,
                        'Fonction'=> $request->fonction,
                    ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delet=User::findOrFail($id);
        $delet->update(['supprimer'=> 1,'Active'=> 0,]);

        return redirect()->back()->with('success', "l'utilisateur a été Supprimé avec success");
    }

    public function activeuser($id)
    {
        $user=User::findOrFail($id);
        $user->update([ 'Active'=> 1, ]);
        // flash("l'utilisateur a été activé avec success");
        return back()->with('success', "l'utilisateur a été activé avec success");
    }
    public function deactiveuser($id)
    {
        $user=User::findOrFail($id);
        $user->update([ 'Active'=> 0,  ]);
        // flash("l'utilisateur a été deactivé avec success");
        return back()->with('success', "l'utilisateur a été déactivé avec success");
    }

    public function connexion()
    {
        return view('layouts.login');
    }

    public function postuserlogin(Request $request)
    {

        $this->validate($request, array(
            'pseudo' => 'required',
            'pass' => 'required',
     ));	
        date_default_timezone_set('UTC'); 
        $datecreation = date('Y-m-d H:i:s');

      $check = User::where('email', '=', $request->pseudo)
                    ->where('Active', '=', "1")
                    ->first();
     if($check){$id=$check->id;}else{$id=null;}
     //dd($request->pseudo,$request->pass);

    if (Auth::attempt(['email' => $request->pseudo, 'password' => $request->pass, 'Active' => 1])) {
        // Success
       Connexionusers::CREATE(
                   ['connexion_outcome' => 1, 'connexion_date' => $datecreation, 'connexion_ip' => $_SERVER["REMOTE_ADDR"], 'user_id' => $id]
                    );
            

        return redirect()->intended('/Accueil');
         
    
    }else{
        // Go back on error (or do what you want)
        Connexionusers::CREATE(
                   ['connexion_outcome' => 0, 'connexion_date' => $datecreation, 'connexion_ip' => $_SERVER["REMOTE_ADDR"], 'user_id' => $id ]
                    );
				  Session::flash('notallowed', 'ERREUR: Identifiant ou Mot de passe incorrect.');
        return redirect()->back();
    }
    }

    public function deconnexion()
    {
       Auth::logout();
       Session::flush();
       Session::save();
        
   return redirect()->intended('/');
    }
}
