<style>
.a_decimal {
    text-align:right;
}


td.LinhaFull
{
    color:#666666;
    font-size:12px;
}
.a_data {
    text-align:center;
    background:#FFDFDF;
    border-bottom:1px solid #FFFFFF;
}
.d_data {
    text-align:center;
    background:#FFE8E8;
    border-bottom:1px solid #FFFFFF;
}
.h_data {
    text-align:center;
    background:#FFC6C6;
    border-bottom:1px solid #FFFFFF;
}


.a_centro {
    text-align:center;
}


.cab_1_1 {
    text-align:center;
    background: #006ca8;
    color:#FFFFFF;
    border-bottom:1px solid #FFFFFF;
    xheight:20px;
    padding:5px;
    font-size:18px;
}

.T_titulo
{
    text-align:center;
    background: #006ca8;
    color:#FFFFFF;
    border-bottom:1px solid #FFFFFF;
    height:20px;
    padding:5px;
    font-size:18px;
}
.L_titulo
{
    text-align:left;
    background: #006ca8;
    color:#FFFFFF;
    border-bottom:1px solid #FFFFFF;
    height:20px;
    padding:5px;
    font-size:18px;
}
</style>
<?php
$idCampo = 'idt';
$Tela = "a Agenda";

$TabelaPrinc      = "grc_atendimento_agenda_log";
$AliasPric        = "grc_aal";
$Entidade         = "Agenda Log";
$Entidade_p       = "Agendas Log";


$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';




$bt_print          = false;

//listar_rel_exportar('')



$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$barra_inc_h = 'Incluir um Novo Agendamento';
$barra_alt_h = 'Alterar o Agendamento';
$barra_con_h = 'Consultar o Agendamento';

// p($_GET);
// p($_SESSION[CS]);

$veio = $_GET['veio'];
//
// Onde estou e quem sou
//
$idt_ponto_atendimento_login = "";
$idt_consultor_login         = "";
$nome_ponto_atendimento_login = $_SESSION[CS]['gdesc_idt_unidade_regional'];
$nome_consultor_login         = $_SESSION[CS]['g_nome_completo'];



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


// Descida para o nivel 2

$prefixow   = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';


 
$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';

$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'idt';
$Filtro['js_tam']    = '0';
if ($fixaunidade==0)
{
    $Filtro['LinhaUm']   = '-- Selecione o PA --';
}
else
{
    //$Filtro['LinhaUm']   = $idt_ponto_atendimento;
}
$Filtro['nome']      = 'Pontos de Atendimento';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;


$delayinicial = '-45 day';
 
$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'dt_ini';
$Filtro['vlPadrao']  = Date('d/m/Y', strtotime($delayinicial));
$Filtro['js']        = 'data';
$Filtro['nome']      = 'Data Inicial Registro';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;
$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'dt_fim';
$Filtro['vlPadrao']  = Date('d/m/Y');
$Filtro['js']        = 'data';
$Filtro['nome']      = 'Data Final Registro';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;

$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'texto';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Protocolo';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['protocolo']  = $Filtro;


$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'texto';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Rastreabilidade Horário';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['id_agenda']  = $Filtro;


$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'texto';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Primeiro Texto';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['texto']  = $Filtro;

$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'texto2';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Segundo Texto';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['texto2']  = $Filtro;



$orderby = "{$AliasPric}.dataregistro";

$vetCampo['idt_atendimento_agenda']      = CriaVetTabela('Rastreabilidade de Horário','','','',$classer_pard,'',$classer_pard);
$vetCampo['dataregistro']   = CriaVetTabela('Data Registro','data','','',$classer_pard,'',$classer_pard);
$vetCampo['tipo']           = CriaVetTabela('Tipo','','','',$classer_pard,'',$classer_pard);

$vetCampo['protocolo']      = CriaVetTabela('Protocolo','','','',$classer_pard,'',$classer_pard);
$vetCampo['grc_aa_data']      = CriaVetTabela('Data Agenda','data','','',$classer_pard,'',$classer_pard);
$vetCampo['grc_aa_hora']      = CriaVetTabela('Hora','data','','',$classer_pard,'',$classer_pard);


$vetCampo['cliente_texto']  = CriaVetTabela('Cliente','','','',$classer_pard,'',$classer_pard);
$vetCampo['pu_nome_completo']  = CriaVetTabela('Responsável','','','',$classer_pard,'',$classer_pard);

$vetCampo['telefone']       = CriaVetTabela('Telefone','','','',$classer_pard,'',$classer_pard);
$vetCampo['celular']        = CriaVetTabela('Celular','','','',$classer_pard,'',$classer_pard);
$vetCampo['assunto']        = CriaVetTabela('Assunto','','','',$classer_pard,'',$classer_pard);

//$classer_pard='h_data';
//$vetCampo["hora"] = CriaVetTabela('Hora','','','',$classer_pard,'',$classer_pard);

//$vetCampo['servicos'] = CriaVetTabela('Serviços');
/* 
$sql   = "select ";
$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";

$sql  .= "   ga.situacao as ga_situacao,  ";

$sql  .= "   ge.descricao as ge_descricao,  ";


$sql  .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";

//$sql  .= "  concat_ws('<br />', concat_ws('','-',ge.descricao) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
$sql  .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";

$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";


$sql  .= "  concat_ws('<br />', grc_aa.cliente_texto, grc_aa.nome_empresa) as cliente_emp,  ";


$sql  .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";
*/



$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo,  ";
$sql  .= "   grc_aa.data as grc_aa_data,   ";
$sql  .= "   grc_aa.hora as grc_aa_hora   ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left  join grc_atendimento_agenda as grc_aa on grc_aa.idt = {$AliasPric}.idt_atendimento_agenda ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_responsavel ";

/*
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
*/

$dt_iniw   = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw   = trata_data($vetFiltro['dt_fim']['valor']);

$sql .= ' where ';

if ($vetFiltro['protocolo']['valor']!="")
{

    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';

}
else
{
   if ($vetFiltro['id_agenda']['valor']!="")
   {
       $dt_agenda=str_replace(' ','',$vetFiltro['id_agenda']['valor']);
       $sql .= " {$AliasPric}.idt_atendimento_agenda = ".null($dt_agenda) ;
   }
   else
   {
		$sql .= " {$AliasPric}.dataregistro >= ".aspa($dt_iniw)." and {$AliasPric}.dataregistro <=  ".aspa($dt_fimw)." " ;
   }
}

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.cliente_texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= ' or lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.cliente_texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.assunto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.tipo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	    $sql .= ' ) ';
}



?>




<script type="text/javascript">
</script>
