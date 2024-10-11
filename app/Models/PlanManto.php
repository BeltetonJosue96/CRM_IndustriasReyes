<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanManto extends Model
{
    use HasFactory;
    protected $table = 'plan_manto';
    protected $primaryKey = 'id_plan_manto';
    public $incrementing = true;
    protected $keyType = 'int';
    public function checklist()
    {
        return $this->hasMany(Checklist::class, 'id_check', 'id_check');
    }
}
