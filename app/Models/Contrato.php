<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empenho;

class Contrato extends Model
{
    protected $table = 'siasg.sidec_contrato';

    protected $primaryKey = 'isn_sidec_contrato';

    public function empenho($id){

        $empenho = Empenho::where('isn_sidec_contrato',$id)->get();

        return $empenho;

    }

    public function aditivo($num, $ug){

        $aditivo = $this->where('IT_NU_CONTRATO',$num)->where('it_co_modalidade_termo','55')->where('it_co_unidade_gestora',$ug);

        return $aditivo;

    }

}
