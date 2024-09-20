<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    public function lineas()
    {
        return $this->hasMany(Linea::class, 'id_producto', 'id_producto');
    }
}
