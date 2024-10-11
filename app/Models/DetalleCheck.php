<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCheck extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'detalle_check';
    protected $primaryKey = 'id_detalle_check';
    public $timestamps = false;

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'id_check',
        'id_control_manto',
        'fecha_manto',
        'id_estado',
        'observaciones',
    ];

    // Relación con la tabla 'checklist'
    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'id_check');
    }

    // Relación con la tabla 'control_de_manto'
    public function controlDeManto()
    {
        return $this->belongsTo(ControlDeManto::class, 'id_control_manto');
    }

    // Relación con la tabla 'estado'
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }
}
