<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlDeManto extends Model
{
    use HasFactory;
    protected $table = 'control_de_manto';
    protected $primaryKey = 'id_control_manto';
    protected $fillable = [
        'id_detalle',
        'id_cliente',
        'id_modelo',
        'id_plan_manto',
        'fecha_venta',
        'proximo_manto',
        'contador',
    ];
    // Relación con la tabla 'detalle_venta'
    public function detalleVenta()
    {
        return $this->belongsTo(DetalleVenta::class, 'id_detalle');
    }

    // Relación con la tabla 'cliente'
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con la tabla 'modelo'
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'id_modelo');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function linea()
    {
        return $this->belongsTo(Linea::class, 'id_linea');
    }

    // Relación con la tabla 'plan_manto'
    public function planManto()
    {
        return $this->belongsTo(PlanManto::class, 'id_plan_manto');
    }
    public function detalleCheck()
    {
        return $this->hasMany(DetalleCheck::class, 'id_control_manto');
    }
}
