<?php

namespace App\Http\Middleware;

use App\Models\Conducteurs;
use App\Models\Ressources;
use App\Models\Vehicules;
use Closure;
use Illuminate\Http\Request;

class Alert
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ressources = Ressources::all();
        view()->share('ressources', $ressources );
        
        $membres = Conducteurs::SELECT('id','NomPrenom','Contact','Email','Address','Reference',)
                                ->WHERE('supprimer', 0)
                                ->orderBy('NomPrenom')
                                ->get();
        view()->share('membres',$membres );

        $voitures = Vehicules::SELECT('id','Matriculation','Marque','Model','supprimer')
                                ->WHERE('supprimer', 0)
                                ->orderBy('Matriculation')
                                ->get();

        view()->share('voitures',$voitures );

        $versemencduc=null;
        view()->share('versemencduc',$versemencduc );
        $reparationvehi=null;
        view()->share('reparationvehi',$reparationvehi );

        return $next($request);
    }
}
