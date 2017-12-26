<?php
$tabela = 'grc_agenda_emailsms';

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_agenda_emailsms';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

$peca = $_GET['peca'];
$idt_peca = $_GET['idt_peca'];

if ($_GET['veio'] == 'pa') { // Portal do ATENDIMENTO
    if ($peca == "P") {
        $sql2 = 'select ';
        $sql2 .= '  a.* ';
        $sql2 .= "  from {$tabela} a";
        $sql2 .= '  where a.padrao = ' . aspa('S');
        $rs_aap = execsql($sql2);
        $row_aap = $rs_aap->data[0];
        $idt_peca = $row_aap['idt'];
        $_GET['id'] = $idt_peca;
    }
}

if ($acao == 'inc') {
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
} else {
    $sql2 = 'select ';
    $sql2 .= '  a.* ';
    $sql2 .= "  from {$tabela} a";
    $sql2 .= '  where a.idt = ' . null($_GET['id']);
    $rs_aap = execsql($sql2);
    $row_aap = $rs_aap->data[0];
    $idt_usuario = $row_aap['idt_responsavel'];
}

if ($_GET['veio'] == 'pa' && $peca == "G") { // Portal do ATENDIMENTO
    $botao_volta = "parent.hidePopWin(true);";
    $botao_acao = '<script type="text/javascript">parent.hidePopWin(true);</script>';
}

if ($_GET['veio'] == 'pa') { // Portal do ATENDIMENTO
    $origem = 'P';

    //$js = " readonly=true style='background:#FFFF70;' ";
    $label = "Código da Peça";
    $label1 = "Classificação da Peça";
} else {
    $origem = 'A';
    $js = " readonly=true style='background:#FFFF70;' ";
    $label = "Código";
    $label1 = "Classificação da Peça";
}

//p($_GET);
if ($_SESSION[CS]['g_id_usuario'] == 1) {
   // $js = "";
}

$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', "{$label}", True, 15, 45, $js);

$vetCampo['classificacao'] = objTexto('classificacao', "{$label1}", false, 15, 45);

//$titulo='Título do E-mail/Texto SMS';
if ($origem == 'P') {
    $titulo = 'Título da Peça';
} else {
    $titulo = 'Título do E-mail';
}

$vetCampo['descricao'] = objTexto('descricao', $titulo, True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
$vetCampo['origem'] = objHidden('origem', $origem);

//
$maxlength = 2000;
$style = "width:800px;";
$js = " style='width:800px;' ";

if ($origem == 'P') {
    $titulo = 'Corpo da Peça';
} else {
    $titulo = 'Corpo do E-MAIL';
}

$vetCampo['detalhe'] = objHtml('detalhe', $titulo, true, '300', '750');

$sql = "select idt, descricao from grc_agenda_emailsms_processo ";
$sql .= " where origem = " . aspa($origem);
$sql .= " order by descricao";
$vetCampo['idt_processo'] = objCmbBanco('idt_processo', 'Processo Associado', true, $sql, '', 'width:300px;');

if ($origem == 'P') {
    $vetTipoAES_t = Array();
    $vetTipoAES_t['E'] = 'E-mail';
    $js = " disabled style='background:#FFFF70;' ";
} else {
    $vetTipoAES_t = $vetTipoAES;
    $js = "";
}

$vetCampo['tipo'] = objCmbVetor('tipo', 'Tipo?', True, $vetTipoAES_t, '', $js);

if ($_GET['veio'] == 'pa' && ($peca == "G" || $rowDados['proprietario'] == 'GESTOR')) { // Portal do ATENDIMENTO
    $vetCampo['padrao'] = objFixoVetor('padrao', 'Peça Padrao?', True, $vetSimNao, ' ', '', '', '', 'N');
} else {
    $vetCampo['padrao'] = objCmbVetor('padrao', 'Peça Padrao?', True, $vetSimNao);
}

$js = " readonly='true' style='background:#FFFF70;' ";
$vetCampo['proprietario'] = objTexto('proprietario', "Proprietário", false, 15, 45, $js);



$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_responsavel'] = objData('data_responsavel', 'Data Registro', false, $js);

$sql = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " where id_usuario = " . null($idt_usuario);
$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsável', 'plu_usuario', 'id_usuario', 'nome_completo', 99);


MesclarCol($vetCampo['idt_processo'], 5);
MesclarCol($vetCampo['origem'], 7);
MesclarCol($vetCampo['detalhe'], 7);

if ($origem == 'P') {
    $label = "<span>Texto do Email</span>";
} else {
    $label = "<span>Texto do Email/SMS</span>";
}
$vetFrm = Array();

if ($origem == 'P') {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['tipo'], '', $vetCampo['ativo']),
        Array($vetCampo['classificacao'], '', $vetCampo['idt_processo']),
        Array($vetCampo['padrao'], '', $vetCampo['proprietario']),
        Array($vetCampo['origem']),
        Array($vetCampo['detalhe']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
} else {
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['tipo'], '', $vetCampo['ativo']),
        Array($vetCampo['classificacao'], '', $vetCampo['idt_processo']),
        Array($vetCampo['origem']),
        Array($vetCampo['detalhe']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}


$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_responsavel']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
