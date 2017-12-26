<?php
$idCampo = 'idt';
$Tela = "o Atendimento";

$TabelaPrinc      = "grc_atendimento";
$AliasPric        = "grc_atd";
$Entidade         = "Atendimento";
$Entidade_p       = "Atendimentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

$barra_inc_img = "imagens/incluir_novo_atendimento.png";
//$barra_alt_img = "imagens/agenda_alterar.png";
//$barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento';
$barra_alt_h = 'Alterar o Atendimento';
$barra_con_h = 'Consultar o Atendimento';

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';



//p($_GET);
//$_GET['instrumento']=1;

echo "<div class='cab_1' >";
$recepcao=$_GET['recepcao'];
$_SESSION[CS]['fu_recepcao'] = $recepcao;
if ($recepcao==1)
{
  echo "  ATENDIMENTO DE RECEPÇÃO";
}

$balcao  = $_GET['balcao'];
if ($_SESSION[CS]['fu_balcao']=="")
{
     $_SESSION[CS]['fu_balcao'] = $balcao;
}
else
{
    $balcao                   = $_SESSION[CS]['fu_balcao'];

}
if ($balcao==1)
{
    echo "  ATENDIMENTO DE BALCAO";
}
$callcenter=$_GET['callcenter'];
$_SESSION[CS]['fu_callcenter'] = $callcenter;
if ($callcenter==1)
{
   echo "  ATENDIMENTO EM CALL CENTER";
}
echo "</div>";


// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

/*
$imagem  = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Diagnóstico', 'grc_atendimento_diagnostico', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

$imagem  = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Produtos', 'grc_atendimento_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
*/

$idt_ponto_atendimento=$_SESSION[CS]['g_idt_unidade_regional'];
$idt_usuario          =$_SESSION[CS]['g_id_usuario'];



//echo " -------------    $idt_ponto_atendimento ";
$fixaunidade=1;

if ($fixaunidade==0)
{   // Todos
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
    $sql  .= ' order by classificacao ';
}
else
{
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    $sql  .= "   and idt = ".null($idt_ponto_atendimento);
    $sql  .= ' order by classificacao ';
}
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'idt';
$Filtro['js_tam']    = '0';
//$Filtro['LinhaUm']   = '-- Selecione o PA --';
$Filtro['nome']      = 'Pontos de Atendimento';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$fixaunidade=0;
$sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
//$sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
if ($idt_ponto_atendimento>0)
{
    $fixaunidade=1;
    $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
}
$sql .= " order by plu_usu.nome_completo";


$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'id_usuario';
$Filtro['js_tam']    = '0';
//$Filtro['LinhaUm']   = '-- Selecione o Consultor --';
$Filtro['nome']      = 'Consultores';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['idt_consultor'] = $Filtro;




   // p($_GET);
    $instrumento = $_GET['instrumento'];
    if ($instrumento>0 and $instrumento<10)
    {
    }
    $vetInstrumento     = Array();
    $vetInstrumento[1]  = 'INFORMAÇÃO';
    $vetInstrumento[2]  = 'ORIENTAÇÃO TÉCNICA';
    $vetInstrumento[3]  = 'CONSULTORIA';
    $vetInstrumento[4]  = 'CURSO';
    $vetInstrumento[5]  = 'FEIRA';
    $vetInstrumento[6]  = 'MISSÃO/CARAVANA';
    $vetInstrumento[7]  = 'OFICINA';
    $vetInstrumento[8]  = 'PALESTRA';
    $vetInstrumento[9]  = 'RODADA DE NEGÓCIO';
    $vetInstrumento[10] = 'SEMINÁRIO';
    $Filtro = Array();
    $Filtro['rs']        = $vetInstrumento;
    $Filtro['id']        = 'instrumento';
    $Filtro['js_tam']    = '0';
    //$Filtro['LinhaUm']   = '-- Selecione o Consultor --';
    $Filtro['nome']      = 'Instrumentos';
    $Filtro['valor']     = trata_id($Filtro);
    $vetFiltro['instrumento'] = $Filtro;







$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'dt_ini';
$Filtro['vlPadrao']  = Date('d/m/Y');
$Filtro['js']        = 'data';
$Filtro['nome']      = 'Data Inicial';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;
//p($Filtro);

$Filtro = Array();
$Filtro['rs']        = 'Texto';
$Filtro['id']        = 'dt_fim';
//$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
$Filtro['vlPadrao']  = Date('d/m/Y');
$Filtro['js']        = 'data';
$Filtro['nome']      = 'Data Final';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;





$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";


if ($vetFiltro['idt_consultor']['valor']!='' AND $vetFiltro['idt_consultor']['valor']!='-1')
{
    // o consultor esta fixado.
}
else
{
    $vetCampo['plu_usu_nome_completo']    = CriaVetTabela('Consultor');
}
$vetCampo['cpf']                      = CriaVetTabela('CPF');
$vetCampo['nome_pessoa']              = CriaVetTabela('Cliente');
$vetCampo['assunto']                  = CriaVetTabela('Assunto');
$vetCampo['data']  = CriaVetTabela('Data','data');
$vetCampo['hora_inicio_atendimento']  = CriaVetTabela('Hora Inicial');
$vetCampo['hora_termino_atendimento']  = CriaVetTabela('Hora Final');
$vetCampo['protocolo']                = CriaVetTabela('Protocolo');
//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "    plu_usu.nome_completo as plu_usu_nome_completo, ";
$sql  .= "    gec_ent.descricao as grc_ent_descricao  ";


//$sql  .= "    If (idt_entidade is null, entidade, gec_ent.descricao) as grc_ent_descricao  ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

$sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
$sql .= " left join ".db_pir_gec."gec_entidade gec_ent on gec_ent.idt = {$AliasPric}.idt_cliente ";

$dt_iniw   = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw   = trata_data($vetFiltro['dt_fim']['valor']);

//if ($vetFiltro['consgetadatas']['valor']=="S")
//{
    $sql .= ' where ';
    $sql .= " data >= ".aspa($dt_iniw)." and data <=  ".aspa($dt_fimw)." " ;
    $fezwere=1;
//}

if ($vetFiltro['idt_ponto_atendimento']['valor']!='' AND $vetFiltro['idt_ponto_atendimento']['valor']!='-1')
{
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    }
    else
    {
        $sql .= ' and ';
    }
    $sql .= ' idt_ponto_atendimento= '.null($vetFiltro['idt_ponto_atendimento']['valor']);

}
if ($vetFiltro['idt_consultor']['valor']!='' AND $vetFiltro['idt_consultor']['valor']!='-1')
{
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    }
    else
    {
        $sql .= ' and ';
    }
    $sql .= ' idt_consultor= '.null($vetFiltro['idt_consultor']['valor']);

}


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.assunto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
// $sql  .= " order by {$orderby}";

if ($sqlOrderby == '') {
        $sqlOrderby = " protocolo asc";
}


?>


<script type="text/javascript">




    var diasint = 15;

    $(document).ready(function () {
    	$('#dt_ini, #dt_fim').change(function () {
    	      valida_dt();
         });
         // Instrumento
         var id='instrumento2';
         objtp = document.getElementById(id);
         if (objtp != null) {
             objtp.value = instrumento;
          }
          var id='div_'+instrumento+'_img';
          objtp = document.getElementById(id);
          if (objtp != null) {
             $(objtp).css('borderColor','#0000FF');
          }

         
         
         
    });

function valida_dt() {
    if (validaDataMaior(false, $('#dt_fim'), 'Dt. Fim', $('#dt_ini'), 'Dt. Inicio') === false) {
		$('#dt_fim').val('');
		$('#dt_fim').focus();
		return false;
           }

    if (newDataHoraStr(false, $('#dt_fim').val()) - newDataHoraStr(false, $('#dt_ini').val()) >= (diasint * 24 * 60 * 60 * 1000)) {
        alert('O intervalo entre as datas não pode ser superior a '+diasint+' dias!');
        $('#dt_fim').val('');
        $('#dt_fim').focus();
        return false;
    }

}



</script>
