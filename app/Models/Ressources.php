<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressources extends Model
{
    protected $fillable = [
        'Rubrique','Autre','user_id','supprimer',
      ];

      public function user(){
        return $this->belongsTo(User::class);
    }
}
