<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparations extends Model
{
    protected $fillable = [
        'typePanne','DetailsPanne','DatePanne','CoutPanne','typeReparation','DetailsReparation','DateReparation','CoutReparation',
        'Status','Active','conducteur_id','vehicule_id','user_id'

  
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
