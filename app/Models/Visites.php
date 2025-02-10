<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visites extends Model
{
    protected $fillable = [
        'DateVisite','DateFin','Attestation','Status','Etat','Reference',
        'conducteur_id','vehicule_id','user_id','supprimer','Details','Montant',
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
