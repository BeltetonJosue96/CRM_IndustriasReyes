<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $table = 'checklist';
    protected $primaryKey = 'id_check';
    protected $fillable = ['fecha_creacion','id_plan_manto'];
    public function planManto()
    {
        return $this->belongsTo(PlanManto::class, 'id_plan_manto');
    }
    public function detalleCheck()
    {
        return $this->hasMany(DetalleCheck::class, 'id_check');
    }
}
