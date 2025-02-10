<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = [
        'Details','Client','Contact','Address','DateDebut','DateFin','Montant','KmDebut',
        'Status','Etat','KmFin','vehicule_id','user_id','Piece','Reference',

  
      ];
  
      public function vehicule(){
          return $this->belongsTo(Vehicules::class);
      }
      public function user(){
          return $this->belongsTo(User::class);
      }
}
