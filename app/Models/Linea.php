<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;
    protected $table = 'linea';
    protected $primaryKey = 'id_linea';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nombre', 'id_producto'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
    public function modelo(){
        return $this->hasMany(Modelo::class, 'id_linea', 'id_linea');
    }
}
