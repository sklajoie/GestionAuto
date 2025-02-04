<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculeConducteurs extends Model
{
    protected $fillable = [
        'dateAsignation','recetteJournalier','Status','Etat','conducteur_id','vehicule_id','user_id','dateFinAsigne'

  
      ];
  
      public function vehicules(){
          return $this->belongsTo(Vehicules::class);
      }
      public function conducteur(){
          return $this->belongsTo(Conducteurs::class);
      }
      public function user(){
          return $this->belongsTo(User::class);
      }
}
