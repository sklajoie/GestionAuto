<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConducteurLocation extends Model
{
    protected $fillable = [
        'Date','location_id','conducteur_id','user_id',

  
      ];
  
      public function location(){
          return $this->belongsTo(Locations::class);
      }
      public function conducteur(){
          return $this->belongsTo(Conducteurs::class);
      }
      public function user(){
          return $this->belongsTo(User::class);
      }
}
