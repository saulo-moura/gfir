<?php
$idCampo = 'idt';
$Tela = "os HeplDesk";
//
$TabelaPrinc      = "plu_email";
$AliasPric        = "plu_e";
$Entidade         = "Email";
$Entidade_p       = "Emails";
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
echo "EMAIL";
echo "</div>";

echo "</div>";

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
$vetCampo['email']     = CriaVetTabela('Email');
$vetCampo['host']      = CriaVetTabela('Host');
$vetCampo['porta']     = CriaVetTabela('Porta');
$vetCampo['opcao']     = CriaVetTabela('Opção');
$vetCampo['box']       = CriaVetTabela('Box');
$sql  = "select {$AliasPric}.* ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= ' where ( 1 = 1 ) ';
if ($vetFiltro['texto']['valor']!='')
{
	$sql .= ' and ( ';
	$sql .= ' lower('.$AliasPric.'.email) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.datahora) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.host) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.porta) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.opcao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower('.$AliasPric.'.box) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' ) ';
}
?>
