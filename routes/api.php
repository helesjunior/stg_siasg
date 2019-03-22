<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/contrato/{uasg}/numero/{id}', function ($uasg,$id) {


    $sql = "select
    c.isn_sidec_contrato id_contrato,
    c.it_co_contrato codigo_contrato,
    c.it_nu_contrato numero_contrato,
    c.it_da_inicio_vigencia data_inicio_vigencia,
    c.it_da_termino_vigencia data_fim_vigencia,
    c.it_no_razao_social_contratado nome_contratado,
    c.it_nu_cgc_cpf_contratado cpf_cnpj_contratado,
    c.it_co_orgao codigo_orgao,
    org.it_no_orgao nome_orgao,
    c.it_co_unidade_gestora codigo_unidade_gestora,
    ug.it_no_unidade_gestora nome_unidade_gestora,
    c.it_nu_processo processo_contratacao,
    c.it_tx_fundamento_legal_contrato fundamento_legal,
    c.it_da_assinatura data_assinatura,
    p.it_da_publicacao data_publicacao,
    c.it_in_situacao_contratado_sicaf situacao,
    c.it_va_total valor_total,
    c.it_nu_aviso_licitacao numero_aviso_licitacao,
    c.it_co_modalidade_licitacao codigo_modalidade_licitacao,
    ml.it_no_modalidade_licitacao nome_modalidade_licitacao,
    c.it_nu_empenho_fatu numero_empenho
    from siasg.sidec_contrato c
    inner join siasg.siasg_orgao org on (org.it_co_orgao = c.it_co_orgao and org.it_no_orgao <> '')
    inner join siasg.siasg_unidade_gestora ug on (ug.it_co_unidade_gestora = c.it_co_unidade_gestora and ug.it_no_unidade_gestora is not null)
    inner join siasg.siasg_tabela_moda_licitacao ml on (ml.it_co_modalidade_licitacao = c.it_co_modalidade_licitacao)
    inner join siasg.sidec_contrato_it_da_publicacao p on (p.isn_sidec_contrato = c.isn_sidec_contrato)
    where
    ug.it_co_unidade_gestora= ?
    and c.it_nu_contrato= ?
    group by 
    c.isn_sidec_contrato,
    c.it_co_contrato,
    c.it_nu_contrato,
    c.it_da_inicio_vigencia,
    c.it_da_termino_vigencia,
    c.it_no_razao_social_contratado,
    c.it_nu_cgc_cpf_contratado,
    c.it_co_orgao,
    org.it_no_orgao,
    c.it_co_unidade_gestora,
    ug.it_no_unidade_gestora,
    c.it_nu_processo,
    c.it_tx_fundamento_legal_contrato,
    c.it_da_assinatura,
    p.it_da_publicacao,
    c.it_in_situacao_contratado_sicaf,
    c.it_va_total,
    c.it_nu_aviso_licitacao,
    c.it_co_modalidade_licitacao,
    ml.it_no_modalidade_licitacao,
    c.it_nu_empenho_fatu;";

    $dados = \Illuminate\Support\Facades\DB::select($sql,[$uasg,$id]);


    $result = [];

    foreach($dados as $d){
        $sql = "SELECT it_tx_objeto_contrato   
        FROM siasg.sidec_contrato_it_tx_objeto_contrato 
        WHERE isn_sidec_contrato = ?  
        ORDER BY cnxarraycolumn;";

        $obs = \Illuminate\Support\Facades\DB::select($sql,[$d->id_contrato]);

        $observacao = '';
       foreach($obs as $o){
            $observacao .= trim(strtoupper(str_replace('                            ','',$o->it_tx_objeto_contrato)));
       }

       $d->it_tx_objeto_contrato = $observacao;
       $result[] = $d;

    }
   
    return json_encode($result);
});


Route::get('/contrato/{uasg}/ano/{ano}', function ($uasg,$ano) {


    $sql = "select
    c.isn_sidec_contrato id_contrato,
    c.it_co_contrato codigo_contrato,
    c.it_nu_contrato numero_contrato,
    c.it_da_inicio_vigencia data_inicio_vigencia,
    c.it_da_termino_vigencia data_fim_vigencia,
    c.it_no_razao_social_contratado nome_contratado,
    c.it_nu_cgc_cpf_contratado cpf_cnpj_contratado,
    c.it_co_orgao codigo_orgao,
    org.it_no_orgao nome_orgao,
    c.it_co_unidade_gestora codigo_unidade_gestora,
    ug.it_no_unidade_gestora nome_unidade_gestora,
    c.it_nu_processo processo_contratacao,
    c.it_tx_fundamento_legal_contrato fundamento_legal,
    c.it_da_assinatura data_assinatura,
    p.it_da_publicacao data_publicacao,
    c.it_in_situacao_contratado_sicaf situacao,
    c.it_va_total valor_total,
    c.it_nu_aviso_licitacao numero_aviso_licitacao,
    c.it_co_modalidade_licitacao codigo_modalidade_licitacao,
    ml.it_no_modalidade_licitacao nome_modalidade_licitacao,
    c.it_nu_empenho_fatu numero_empenho
    from siasg.sidec_contrato c
    inner join siasg.siasg_orgao org on (org.it_co_orgao = c.it_co_orgao and org.it_no_orgao <> '')
    inner join siasg.siasg_unidade_gestora ug on (ug.it_co_unidade_gestora = c.it_co_unidade_gestora and ug.it_no_unidade_gestora is not null)
    inner join siasg.siasg_tabela_moda_licitacao ml on (ml.it_co_modalidade_licitacao = c.it_co_modalidade_licitacao)
    inner join siasg.sidec_contrato_it_da_publicacao p on (p.isn_sidec_contrato = c.isn_sidec_contrato)
    where
    ug.it_co_unidade_gestora= ?
    and left(c.it_da_assinatura, 4) = ?
    group by 
    c.isn_sidec_contrato,
    c.it_co_contrato,
    c.it_nu_contrato,
    c.it_da_inicio_vigencia,
    c.it_da_termino_vigencia,
    c.it_no_razao_social_contratado,
    c.it_nu_cgc_cpf_contratado,
    c.it_co_orgao,
    org.it_no_orgao,
    c.it_co_unidade_gestora,
    ug.it_no_unidade_gestora,
    c.it_nu_processo,
    c.it_tx_fundamento_legal_contrato,
    c.it_da_assinatura,
    p.it_da_publicacao,
    c.it_in_situacao_contratado_sicaf,
    c.it_va_total,
    c.it_nu_aviso_licitacao,
    c.it_co_modalidade_licitacao,
    ml.it_no_modalidade_licitacao,
    c.it_nu_empenho_fatu;";

    $dados = \Illuminate\Support\Facades\DB::select($sql,[$uasg,$ano]);

    
    $result = [];

    foreach($dados as $d){
        $sql = "SELECT it_tx_objeto_contrato   
        FROM siasg.sidec_contrato_it_tx_objeto_contrato 
        WHERE isn_sidec_contrato = ?  
        ORDER BY cnxarraycolumn;";

        $obs = \Illuminate\Support\Facades\DB::select($sql,[$d->id_contrato]);

        $observacao = '';
       foreach($obs as $o){
            $observacao .= trim(strtoupper(str_replace('                            ','',$o->it_tx_objeto_contrato)));
       }


       $d->it_tx_objeto_contrato = $observacao;
       $result[] = $d;
       

    }
   
    return json_encode($result);
});

