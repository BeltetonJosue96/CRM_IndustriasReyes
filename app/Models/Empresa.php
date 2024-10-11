<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    public $incrementing = true;
    protected $keyType = 'int';
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'id_empresa', 'id_empresa');
    }
}
