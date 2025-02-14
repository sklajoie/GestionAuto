<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'Etape','Details','Date','entretien_id','essence_id','vidange_id','visite_id','assurance_id',
        'versement_id','vehicule_id','location_id','user_id','conducteur_id',

  
      ];
  
      public function vehicule(){
          return $this->belongsTo(Vehicules::class);
      }
      public function conducteur(){
          return $this->belongsTo(Conducteurs::class);
      }
      public function entretien(){
          return $this->belongsTo(Entretiens::class);
      }
      public function essence(){
          return $this->belongsTo(Essences::class);
      }
      public function vidange(){
          return $this->belongsTo(Vidanges::class);
      }
      public function visite(){
          return $this->belongsTo(Visites::class);
      }
      public function assurance(){
          return $this->belongsTo(Assurances::class);
      }
      public function versement(){
          return $this->belongsTo(Versements::class);
      }
      public function location(){
          return $this->belongsTo(Locations::class);
      }
      public function user(){
          return $this->belongsTo(User::class);
      }
}
