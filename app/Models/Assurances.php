<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assurances extends Model
{
    protected $fillable = [
        'NomAssurance','CompagnieAssurance','DateDebut','DateFin','Attestation','Status','Etat',
        'conducteur_id','vehicule_id','user_id','supprimer','Details','Reference','Montant',
      ];

      public function conducteur(){
        return $this->belongsTo(Conducteurs::class);
    }
      public function vehicule(){
        return $this->belongsTo(Vehicules::class);
    }
      public function user(){
        return $this->belongsTo(User::class);
    }
}
