<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astillero extends Model
{
    use HasFactory;
    
    protected $table = 'astillero';
    
    protected $fillable = ['nombre'];
    
    function yates() {
        return $this->hasMany('App\Models\Yate', 'idastillero');
    }
}
