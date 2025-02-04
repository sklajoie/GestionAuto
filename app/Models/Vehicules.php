<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicules extends Model
{
    protected $fillable = [
        'Matriculation','Marque','Model','Chassis','NombrePlace','DateAcquisition','Couleur','Active','Status','supprimer','user_id',
        'Type',
  
      ];

      public function assurance(){
        return $this->hasMany(Assurances::class, 'vehicule_id')->where('Etat', 0);
    }
    public function visite(){
        return $this->hasMany(Visites::class, 'vehicule_id')->where('Etat', 0);
    }
    public function vidanges(){
        return $this->hasMany(Vidanges::class, 'vehicule_id')->where('Etat', 0);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
