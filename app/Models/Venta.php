<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $fillable = ['fecha_venta', 'descripcion', 'id_cliente'];
    protected $primaryKey = 'id_venta';

    // Define the relationship with Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
