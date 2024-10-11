<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $table = 'detalle_venta';
    protected $primaryKey = 'id_detalle';
    protected $fillable = [
        'costo',
        'id_venta',
        'id_plan_manto',
        'id_modelo'
    ];
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'id_modelo');
    }
    public function planManto()
    {
        return $this->belongsTo(PlanManto::class, 'id_plan_manto');
    }
    public function controlDeManto()
    {
        return $this->hasOne(ControlDeManto::class, 'id_detalle');
    }

}
