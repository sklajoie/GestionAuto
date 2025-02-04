<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conducteurs extends Model
{
    protected $fillable = [
        'NomPrenom','Contact','Email','Address','Reference','Permis','Active','Status','supprimer','user_id',
  
      ];
  
      // public function vehicules(){
      //     return $this->belongsTo(vehicules::class);
      // }
}
