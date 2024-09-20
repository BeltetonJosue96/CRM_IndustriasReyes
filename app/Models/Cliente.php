<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'nombre',
        'apellidos',
        'identificacion',
        'telefono',
        'id_empresa',
        'cargo',
        'direccion',
        'referencia',
        'municipio',
        'id_departamento',
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }
}
