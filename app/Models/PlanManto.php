<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanManto extends Model
{
    use HasFactory;
    protected $table = 'plan_manto';
    protected $primaryKey = 'id_plan_manto';
}
