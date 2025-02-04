<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Versements extends Model
{
    protected $fillable = [
        'Montant','MoyenPaiemet','Reference','Details','Status','conducteur_id','vehicule_id','user_id',
        'Rubrique','pieceJointe','date','Beneficier','Type','Mouvement','codePaiement',

  
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
