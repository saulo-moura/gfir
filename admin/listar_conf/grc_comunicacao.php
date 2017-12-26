<?php
$idCampo = 'idt';
$Tela = "a Comunicação com o Cliente";
//
$TabelaPrinc      = "grc_comunicacao";
$AliasPric        = "grc_c";
$Entidade         = "Comunicação";
$Entidade_p       = "Comunicações";
$CampoPricPai     = "";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';

$direto=$_GET['direto'];
if ($direto=='S')
{
	$barra_inc_ap = true;
	$barra_alt_ap = false;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}
else
{
	$barra_inc_ap = false;
	$barra_alt_ap = false;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}

/*
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
echo "COMUNICAÇÃO COM O CLIENTE";
echo "</div>";

echo "</div>";
*/



$delayinicial = '-45 day';
 


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_registro_ini';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data de Registro de';
$Filtro['vlPadrao']  = Date('d/m/Y', strtotime($delayinicial));
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_registro_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_registro_fim';
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data de Registro até';
$Filtro['vlPadrao']  = Date('d/m/Y');
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_dt_registro_fim'] = $Filtro;


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

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'numero_protocolo';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Número Protocolo';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['filtro_numero_protocolo'] = $Filtro;

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
$vetCampo['nome']                 = CriaVetTabela('Quem Enviou<br />Endereço');
if ($direto!='S')
{
    $vetCampo['login']                = CriaVetTabela('login<br >de envio');
    //$vetCampo['nome']                 = CriaVetTabela('nome');
}
//
$vetCampo['protocolo']            = CriaVetTabela('Protocolo<br />  de Envio');
$vetCampo['datahora']             = CriaVetTabela('Data Registro','data');

$vetCampo['titulo']               = CriaVetTabela('Título');
$vetCampo['cliente_nome']      = CriaVetTabela('Quem Recebeu<br />Endereço');


//$vetCampo['ip']                   = CriaVetTabela('IP');
//$vetCampo['macroprocesso']        = CriaVetTabela('macroprocesso');
$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] ='Problema no Sistema'; 
$vetTipoSolicitacaoHD['RE'] ='Dúvida do Sistema'; 
//$vetCampo['tipo_solicitacao']  = CriaVetTabela('Tipo','descDominio',$vetTipoSolicitacaoHD);

/*
$vetStatusHD = Array();
$vetStatusHD['A'] ='Aberto'; 
$vetStatusHD['R'] ='Registrado'; 
$vetStatusHD['F'] ='Fechado'; 
$vetCampo['status']        = CriaVetTabela('status','descDominio',$vetStatusHD);
*/
//$vetCampo['macro_ip']      = CriaVetTabela('Macroprocesso<br />IP');


$login = $_SESSION[CS]['g_login'];
$sql  = "select {$AliasPric}.*, ";
$sql .= "        concat_ws('<br />',macroprocesso, ip) as macro_ip, ";
$sql .= "        concat_ws('<br />',titulo, descricao) as titulo, ";
$sql .= "        concat_ws('<br />',cliente_nome, cliente_email) as cliente_nome, ";
$sql .= "        concat_ws('<br />',nome, email) as nome ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
// $sql .= " left  join plu_usuario plu_u on plu_u.login = {$AliasPric}.login ";
// $sql .= " where ( idt_helpdesk is null ) "; // pegar os registros do Pai



if ($direto=='S')
{
    $sql .= ' where ( login = '.aspa($login)." ) ";
	$sql .= '   and ( flag_logico = '.aspa('A')." ) ";
}
else
{
    $sql .= ' where ( 1 = 1 ) ';
	//$sql .= ' where ( flag_logico = '.aspa('A')." ) ";

}
 $registro_ini = $vetFiltro['filtro_dt_registro_ini']['valor'].' 00:00:00';
if ($vetFiltro['filtro_dt_registro_ini']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.datahora >= '.aspa(trata_data($registro_ini));
}
$registro_fim = $vetFiltro['filtro_dt_registro_fim']['valor'].' 23:59:59';
if ($vetFiltro['filtro_dt_registro_fim']['valor'] != "") {
    $sql .= ' and '.$AliasPric.'.datahora <= '.aspa(trata_data($registro_fim));
}





if ($vetFiltro['filtro_status']['valor'] != "" && $vetFiltro['filtro_status']['valor'] != "0" && $vetFiltro['filtro_status']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.status = '.aspa($vetFiltro['filtro_status']['valor']);
}





if ($vetFiltro['filtro_numero_protocolo']['valor']!='')
{
	$sql .= ' and ( ';
	$sql .= ' lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['filtro_numero_protocolo']['valor'], '%', '%').')';
	$sql .= ' ) ';
}



if ($vetFiltro['texto']['valor']!='')
{
	$sql .= ' and ( ';
	$sql .= ' lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.datahora) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= ' or lower('.$AliasPric.'.cliente_nome) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.cliente_email) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	
	$sql .= ' or lower('.$AliasPric.'.login) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.titulo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.nome) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.email) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.macroprocesso) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.ip) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' ) ';
}

?>
