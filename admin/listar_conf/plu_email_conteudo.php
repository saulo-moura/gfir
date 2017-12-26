<?php
$idCampo = 'idt';
$Tela = "os HeplDesk";
//
$TabelaPrinc      = "plu_email_conteudo";
$AliasPric        = "plu_ec";
$Entidade         = "Email Conteudo";
$Entidade_p       = "Emails Conteudo";
$CampoPricPai     = "";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';


echo "<div class='barratitulo_conf'>";

echo "<div class='barratitulo_conf' onclick='return Voltar_f();' style='padding-top:0.5em; width:5%; float:left; cursor:pointer;'>";

 $imgw = "<img width='25' height='25' src='imagens/bt_voltar_g.png' title='Voltar'/>";
//echo "VOLTAR";

echo $imgw;
echo "</div>";
echo "<script>";
echo "function Voltar_f() { self.location = 'conteudo.php'; }";
echo "</script>";

echo "<div class='barratitulo_conf' style='padding-top:0.5em; width:95%; float:left;'>";
echo "EMAIL - CONTEÚDO";
echo "</div>";
echo "</div>";



$sql = '';
$sql .= ' select idt, email ';
$sql .= ' from plu_email ';
$sql .= ' order by email';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Email';
//$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_email'] = $Filtro;


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_registro_ini';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data de Registro de';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_registro_ini'] = $Filtro;
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_registro_fim';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data de Registro até';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_registro_fim'] = $Filtro;

/*
$Filtro = Array();
$vetStatusHD = Array();
$vetStatusHD['A'] ='Aberto'; 
$vetStatusHD['R'] ='Registrado'; 
$vetStatusHD['F'] ='Fechado'; 
$Filtro['rs'] = $vetStatusHD;
$Filtro['id'] = 'filtro_status';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Status';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_status'] = $Filtro;
*/

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'numero';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Número';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['filtro_numero'] = $Filtro;

//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
// Monta o vetor de Campo
//
$vetCampo=Array();

$vetCampo['origem']      = CriaVetTabela('Enviado por:');
$vetCampo['numero']      = CriaVetTabela('Número');
$vetCampo['datahora']    = CriaVetTabela('Data Registro','data');
$vetCampo['titulo']      = CriaVetTabela('Título');
//$vetCampo['plu_e_email'] = CriaVetTabela('Email');
 
/*
$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] ='Problema no Sistema'; 
$vetTipoSolicitacaoHD['RE'] ='Dúvida do Sistema'; 
$vetCampo['tipo_solicitacao']  = CriaVetTabela('Tipo','descDominio',$vetTipoSolicitacaoHD);
*/
$login = $_SESSION[CS]['g_login'];
$sql  = "select {$AliasPric}.*, ";
$sql .= "        plu_e.email as plu_e_email ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join plu_email plu_e on plu_e.idt = {$AliasPric}.idt_email ";
$sql .= " where {$AliasPric}.idt_email = ".null($vetFiltro['idt_email']['valor']); 

/*
if ($direto=='S')
{
    $sql .= ' where ( login = '.aspa($login)." ) ";
	$sql .= '   and ( flag_logico = '.aspa('A')." ) ";
}
else
{
    //$sql .= ' where ( 1 = 1 ) ';
	$sql .= ' where ( flag_logico = '.aspa('A')." ) ";
}
*/

$registro_ini = $vetFiltro['filtro_dt_registro_ini']['valor'].' 00:00:00';
if ($vetFiltro['filtro_dt_registro_ini']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.datahora >= '.aspa(trata_data($registro_ini));
}
$registro_fim = $vetFiltro['filtro_dt_registro_fim']['valor'].' 23:59:59';
if ($vetFiltro['filtro_dt_registro_fim']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.datahora <= '.aspa(trata_data($registro_fim));
}





/*
if ($vetFiltro['filtro_status']['valor'] != "" && $vetFiltro['filtro_status']['valor'] != "0" && $vetFiltro['filtro_status']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.status = '.aspa($vetFiltro['filtro_status']['valor']);
}

if ($vetFiltro['filtro_numero_protocolo']['valor']!='')
{
	$sql .= ' and ( ';
	$sql .= ' lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['filtro_numero_protocolo']['valor'], '%', '%').')';
	$sql .= ' ) ';
}
*/


if ($vetFiltro['texto']['valor']!='')
{
	$sql .= ' and ( ';
	$sql .= ' lower('.$AliasPric.'.numero) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.datahora) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.titulo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.corpo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' ) ';
}

?>
