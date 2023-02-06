<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    
    protected $table = 'tipo';
    
    public $timestamps = false;
    
    protected $fillable = ['nombre'];
    
    function yates() {
        return $this->hasMany('App\Models\Yate', 'idtipo');
    }
}
