<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entretiens extends Model
{
    protected $fillable = [
        'Type','Montant','Description','Date','Garage','Kmg','Etat','Rappel',
        'Status','conducteur_id','vehicule_id','user_id','Reference','supprimer',

  
      ];
  
      public function vehicule(){
          return $this->belongsTo(Vehicules::class);
      }
      public function conducteur(){
          return $this->belongsTo(Conducteurs::class);
      }
      public function user(){
          return $this->belongsTo(User::class);
      }
}
