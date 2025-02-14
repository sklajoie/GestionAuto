<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersementLocation extends Model
{
    protected $fillable = [
        'Montant','Date','location_id','user_id','MoyenPaiemet',

  
      ];
  
      public function location(){
          return $this->belongsTo(Locations::class);
      }
      
      public function user(){
          return $this->belongsTo(User::class);
      }
}
