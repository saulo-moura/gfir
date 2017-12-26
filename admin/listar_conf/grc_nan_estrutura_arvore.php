<style>
  .proprio {
      width:100%;
      background: #2F66B8;
      color     : #FFFFFF;
      text-align: center;
      font-size:18px;
      height:20px;
      padding:10px;
      
  }
</style>
<?php
$idCampo = 'idt';
$Tela = "os Atores do NAN";

$TabelaPrinc      = "grc_nan_estrutura";
$AliasPric        = "grc_ne";
$Entidade         = "Ator do NAN";
$Entidade_p       = "Atores do NAN";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

/*
$externo = $_GET['externo'];
echo "<div class='proprio'>";

if ($externo!='S')
{
     echo "LOCAIS PRÓPRIOS";
}
else
{
     echo "LOCAIS EXTERNOS";
}
echo "</div>";
*/


$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
//$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= " where tipo_estrutura = 'UR' ";
$sql  .= ' order by descricao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Unidade Regional';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//$vetCampo['codigo']             = CriaVetTabela('Código');
$vetCampo['grc_nte_descricao']  = CriaVetTabela('Tipo de Ator');
$vetCampo['plu_usuario']         = CriaVetTabela('Ator');
$vetCampo['plu_usut_usuario']         = CriaVetTabela('Estrutura');


$vetCampo['grc_pa_descricao']         = CriaVetTabela('Ação');

//$vetCampo['detalhe']            = CriaVetTabela('Observação');
$vetCampo['ativo']              = CriaVetTabela('Ativo?','descDominio',$vetSimNao);




$sql   = "select ";
$sql  .= "   {$AliasPric}.*, ";

$sql  .= "   grc_pa.descricao as grc_pa_descricao,  ";
$sql  .= "   grc_nte.descricao as grc_nte_descricao,  ";
$sql  .= "   plu_usu.nome_completo as plu_usuario,  ";
$sql  .= "   plu_usut.nome_completo as plu_usut_usuario  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join grc_nan_estrutura_tipo grc_nte on grc_nte.idt = {$AliasPric}.idt_nan_tipo ";

$sql  .= " left  join grc_projeto_acao grc_pa on grc_pa.idt = {$AliasPric}.idt_acao ";

$sql  .= " left  join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario ";
$sql  .= " left  join grc_nan_estrutura grc_net on grc_net.idt = {$AliasPric}.idt_tutor ";
$sql  .= " left  join plu_usuario plu_usut on plu_usut.id_usuario = grc_net.idt_usuario ";
$sql  .= ' where ';
$sql  .= ' grc_ne.idt_ponto_atendimento = '.null($vetFiltro['ponto_atendimento']['valor']);

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '     lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= '  or lower(detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

//if ($sqlOrderby == '') {
//    $sqlOrderby = "grc_nte.codigo asc";
//}
$sql  .= ' order by grc_ne.idt_tutor asc , grc_nte.codigo asc ';


?>
