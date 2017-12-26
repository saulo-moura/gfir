<?php
$idCampo = 'idt';
$Tela = "os HeplDesk";
//
$TabelaPrinc = "plu_helpdesk";
$AliasPric = "plu_hd";
$Entidade = "HelpDesk";
$Entidade_p = "HelpDesks";
$CampoPricPai = "";


$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$direto = $_GET['direto'];
if ($direto == 'S') {
    $barra_inc_ap = true;
    $barra_alt_ap = false;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
} else {
    $barra_inc_ap = true;
    $barra_alt_ap = false;
    $barra_con_ap = true;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
}


echo "<div class='barratitulo_conf'>";

if ($_SESSION[CS]['g_abrir_sistema'] == '') {
    echo "<div onclick='return Voltar_f();' style='width:5%; float:left; cursor:pointer;'>";
    echo "<img width='25' height='25' src='imagens/bt_voltar_g.png' title='Voltar'/>";
    echo "</div>";
    echo "<script>";
    echo "function Voltar_f() { self.location = 'conteudo.php'; }";
    echo "</script>";
}

if ($_SESSION[CS]['g_id_usuario'] != '') {
    $menu_acesso = '';
}

echo "<div style='width:95%; float:left;'>";
echo "SUPORTE TÉCNICO";
echo "</div>";

echo "</div>";


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
$login = $_SESSION[CS]['g_login'];
$sql = "select distinct {$AliasPric}.status_helpdesk_usuario, {$AliasPric}.status_helpdesk_usuario as descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= ' where ( login = ' . aspa($login) . " ) ";
$sql .= '   and ( flag_logico = ' . aspa('A') . " ) ";
$rs = execsql($sql);
$Filtro['rs'] = $rs;
$Filtro['id'] = 'status_helpdesk_usuario';
//$Filtro['id_select'] = 'status_helpdesk_usuario';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Status';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_status'] = $Filtro;




$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'numero_protocolo';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Número Protocolo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_numero_protocolo'] = $Filtro;

//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
// Monta o vetor de Campo
//
$vetCampo = Array();
$vetCampo['datahora'] = CriaVetTabela('Data Registro', 'data');
$vetCampo['protocolo'] = CriaVetTabela('Protocolo');
$vetCampo['numero_id_helpdesk_usuario'] = CriaVetTabela('Ticket');

if ($direto != 'S') {
    $vetCampo['login'] = CriaVetTabela('login');
    $vetCampo['nome'] = CriaVetTabela('nome');
}
$vetCampo['titulo'] = CriaVetTabela('Título');


//$vetCampo['ip']                   = CriaVetTabela('IP');
//$vetCampo['macroprocesso']        = CriaVetTabela('macroprocesso');
$vetTipoSolicitacaoHD = Array();
$vetTipoSolicitacaoHD['PS'] = 'Problema no Sistema';
$vetTipoSolicitacaoHD['RE'] = 'Dúvida do Sistema';
$vetCampo['tipo_solicitacao'] = CriaVetTabela('Tipo', 'descDominio', $vetTipoSolicitacaoHD);

$vetStatusHD = Array();
$vetStatusHD['A'] = 'Aberto';
$vetStatusHD['R'] = 'Registrado';
$vetStatusHD['F'] = 'Fechado';
//$vetCampo['status']        = CriaVetTabela('status','descDominio',$vetStatusHD);


$vetCampo['status_helpdesk_usuario'] = CriaVetTabela('Status');

//$vetCampo['macro_ip']      = CriaVetTabela('Macroprocesso<br />IP');



$sql = "select {$AliasPric}.*, ";
$sql .= "        concat_ws('<br />',macroprocesso, ip) as macro_ip, ";
$sql .= "        concat_ws('<br />',titulo, descricao) as titulo, ";
$sql .= "        concat_ws('<br />',nome, email) as nome ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
// $sql .= " left  join plu_usuario plu_u on plu_u.login = {$AliasPric}.login ";
// $sql .= " where ( idt_helpdesk is null ) "; // pegar os registros do Pai
if ($direto == 'S') {
    $sql .= ' where ( login = ' . aspa($login) . " ) ";
    $sql .= '   and ( flag_logico = ' . aspa('A') . " ) ";
} else {
    //$sql .= ' where ( 1 = 1 ) ';
    $sql .= ' where ( flag_logico = ' . aspa('A') . " ) ";
}

$registro_ini = $vetFiltro['filtro_dt_registro_ini']['valor'] . ' 00:00:00';
if ($vetFiltro['filtro_dt_registro_ini']['valor'] != "") {
    $sql .= ' and ' . $AliasPric . '.datahora >= ' . aspa(trata_data($registro_ini));
}
$registro_fim = $vetFiltro['filtro_dt_registro_fim']['valor'] . ' 23:59:59';
if ($vetFiltro['filtro_dt_registro_fim']['valor'] != "") {
    $sql .= ' and ' . $AliasPric . '.datahora <= ' . aspa(trata_data($registro_fim));
}






if ($vetFiltro['filtro_status']['valor'] != "" && $vetFiltro['filtro_status']['valor'] != "0" && $vetFiltro['filtro_status']['valor'] != "-1") {
    $sql .= ' and ' . $AliasPric . '.status_helpdesk_usuario = ' . aspa($vetFiltro['filtro_status']['valor']);
}

//p($sql);


if ($vetFiltro['filtro_numero_protocolo']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower(' . $AliasPric . '.protocolo) like lower(' . aspa($vetFiltro['filtro_numero_protocolo']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}



if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and ( ';
    $sql .= ' lower(' . $AliasPric . '.protocolo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.datahora) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.login) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.titulo) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.nome) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.email) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.macroprocesso) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.ip) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
?>
