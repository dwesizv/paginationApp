<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yate extends Model
{
    use HasFactory;
    
    protected $table = 'yate';
    
    protected $fillable = [
                    'iduser',
                    'idastillero',
                    'idtipo',
                    'nombre',
                    'descripcion',
                    'precio'
                ];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'iduser');
    }
    
    public function tipo() {
        return $this->belongsTo('App\Models\Tipo', 'idtipo');
    }
    
    public function astillero() {
        return $this->belongsTo('App\Models\Astillero', 'idastillero');
    }
}
