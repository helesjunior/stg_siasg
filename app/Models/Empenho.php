<?php

namespace App\Models;
use App\Models\Contrato;

use Illuminate\Database\Eloquent\Model;

class Empenho extends Model
{
    protected $table = 'siasg.sidec_contrato_gr_empenho';

    public function contrato(){

        return $this->belongsTo(\Contrato::class, 'isn_sidec_contrato');

    }

}
