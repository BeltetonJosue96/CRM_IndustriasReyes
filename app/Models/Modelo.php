<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
    protected $table = 'modelo';
    protected $primaryKey = 'id_modelo';

    protected $fillable = ['codigo', 'descripcion', 'id_linea'];
    public function linea(){
        return $this->belongsTo(Linea::class, 'id_linea');
    }
}
