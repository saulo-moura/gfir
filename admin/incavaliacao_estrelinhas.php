<style>
.div1_estrela {
   background:#FFFFFF;
   color:#000000;
   
}
.div2_estrela {
   background:#FFFFFF;
   color:#000000;
   font-family : Calibri, Arial, Helvetica, sans-serif;
   font-size: 1.0em;
   color: #0000FF;
   font-weight: bold;
}
.div3_estrela {
   background:#FFFFFF;
   color:#000000;
   width:100%;
   text-align:center;
}
.estrela {
   width:20px;
   height:20px;
}
.botao_ag_bl {
	text-align:center;
	width:6em;
	height:2em;
	color:#FFFFFF;
	background:#2F65BB;
	font-size:1em;
	cursor:pointer;
	display: inline-block;
	xmargin-top:10px;
	xmargin-right:10px;
	font-weight:bold;
	border-radius: 0.5em;
	

}
.botao_ag_bl:hover {
	background:#0000FF;
}

.div_estrelinha {
   background:#FFFFFF;
   xwidth:25%;
   width:100%;
   xborder:1px solid red;
   float:left;
   Xheight:20em;
   text-align:center;
}
.div_cliente {
   background:#FFFFFF;
   xwidth:43%;
   xborder-bottom:1px solid #C0C0C0;
   float:left;
   xheight:10em;
   text-align:left;
   font-family : Calibri, Arial, Helvetica, sans-serif;
   font-size: 1.1em;
   color: #0000FF;
   font-weight: bold;
}
.div_estrelinha_g {
   xwidth:100%;
   height:10em;
   xborder-bottom:1px solid #C0C0C0;
   float:left;
}
</style>
<?php
/*	
	SELECT (grcfr.codigo * grcfr.qtd_pontos) as total       ,grcfr.*, grca.*, grcar.* FROM `db_pir_grc`.`grc_avaliacao` grca
inner join `db_pir_grc`.`grc_avaliacao_resposta` grcar on grcar.idt_avaliacao = grca.idt
inner join `db_pir_grc`.`grc_formulario_resposta` grcfr on grcfr.idt = grcar.idt_resposta
where grca.idt_formulario = 14
*/

//p($_SESSION[CS]);


$idt_cliente   = $_SESSION[CS]['g_id_usuario'];
$nome_cliente  = $_SESSION[CS]['g_nome_completo'];
$cpf           = $_SESSION[CS]['g_cpf'];
if ($cpf=='')
{
    //$cpf='061846425-53'; 
	echo "<div style='background:#FF0000; color:#FFFFFF; font_size:16px; padding:15px; text-align:center;'>";  
	echo "Usuário Logado como $nome_cliente não tem o CPF informado.\nNão pode AVALIAR EVENTOS.";  
	echo "</div>";  
	exit();
}
else
{
	echo "<div style='font-weight: bold; background:#0000FF; color:#FFFFFF; font_size:16px; padding:15px; text-align:left;'>";  
	echo "CLIENTE: $cpf - $nome_cliente";  
	echo "</div>";  

}
$vetEvento=Array();
$sql  = '';
$sql .= ' select ';
$sql .= ' grc_e.idt as idt_evento, ';
$sql .= ' grc_ap.cpf, ';
$sql .= ' grc_ap.nome as nome_cliente, ';
$sql .= ' grc_e.codigo, ';
$sql .= ' grc_e.descricao, ';
$sql .= ' grc_a.protocolo, ';
$sql .= ' grc_e.dt_previsao_inicial, ';
$sql .= ' grc_e.dt_previsao_fim ';
//$sql .= ' grc_e.* ';
$sql .= ' from grc_evento grc_e';
$sql .= ' inner join grc_atendimento         grc_a  on grc_a.idt_evento       = grc_e.idt';
$sql .= ' inner join grc_atendimento_pessoa  grc_ap on grc_ap.idt_atendimento = grc_a.idt';
$sql .= ' inner join grc_evento_participante grc_ep on grc_ep.idt_atendimento = grc_a.idt';
$sql .= ' where grc_ap.cpf = ' . aspa($cpf);
$rs = execsql($sql);
//p($sql);
$vetEventoAvaliacao=Array();
foreach ($rs->data as $row) {
    $idt_evento = $row['idt_evento'];
	$cpf        = $row['cpf'];
	$codigo     = $row['codigo'];
	$descricao  = $row['descricao'];
	$vetEvento[$idt_evento]=$row;
	// Verificar se já respondeu
	/*	
	SELECT (grcfr.codigo * grcfr.qtd_pontos) as total       ,grcfr.*, grca.*, grcar.* FROM `db_pir_grc`.`grc_avaliacao` grca
	inner join `db_pir_grc`.`grc_avaliacao_resposta` grcar on grcar.idt_avaliacao = grca.idt
	inner join `db_pir_grc`.`grc_formulario_resposta` grcfr on grcfr.idt = grcar.idt_resposta
	where grca.idt_formulario = 14
	*/
	$sqla  = '';
	$sqla .= ' select ';
	$sqla .= ' grc_fr.codigo, ';
	$sqla .= ' grc_fr.qtd_pontos ';
	$sqla .= ' from grc_avaliacao grc_av';
	$sqla .= ' inner join grc_avaliacao_resposta  grc_ar on grc_ar.idt_avaliacao = grc_av.idt';
	$sqla .= ' inner join grc_formulario_resposta grc_fr on grc_fr.idt = grc_ar.idt_resposta';
	$sqla .= ' inner join grc_formulario grc_f on grc_f.idt = grc_av.idt_formulario';
	//$sqla .= ' where grc_av.idt_formulario = 14'; // esta fixo o idt do formulario de estrelinha
	$sqla .= ' where grc_f.codigo = '.aspa('700'); // esta fixo o idt do formulario de estrelinha
	$sqla .= '   and grc_av.cpf        = '.aspa($cpf);
	$sqla .= '   and grc_av.idt_evento = '.null($idt_evento);
	$rsa = execsql($sqla);
	//p($sqla);
	if ($rsa->rows > 0)
	{
		foreach ($rsa->data as $rowa) {
		   $vet=Array();
		   $vet['codigo']         = $rowa['codigo'];
		   $vet['qtd_pontos']     = $rowa['qtd_pontos'];
		   $vet['nota_avaliacao'] = ($rowa['codigo'] * $rowa['qtd_pontos']);
		   $vetEventoAvaliacao[$cpf][$idt_evento]=$vet;
		}
	}
	else
	{
	   // Não respondeu
	}
}

//p($vetEvento);
//p($vetEventoAvaliacao);


$estrela1 = "Uma Estrelinha = 0";
$estrela2 = "Duas Estrelinha = 25";
$estrela3 = "Três Estrelinha = 50";
$estrela4 = "Quatro Estrelinha = 75";
$estrela5 = "Cinco Estrelinha = 100";


foreach ($vetEvento as $idt_evento => $row) {
    $cpf          = $row['cpf'];
	$idt_evento   = $row['idt_evento'];
    $nome_cliente = $row['nome_cliente'];
	$codigo       = $row['codigo'];
	$descricao    = $row['descricao'];
	$protocolo    = $row['protocolo'];
	$dt_previsao_inicial  = trata_data($row['dt_previsao_inicial']);
	$dt_previsao_fim      = trata_data($row['dt_previsao_fim']);
	
	//echo " <div class='div_estrelinha_g' style='border-bottom:1px solid #C0C0C0;'>";
	echo "<section style='xheight:12em; border-bottom:1px solid #F0F0F0; border-top:1px solid #E0E0E0; float:left; width:100%; '>";
	
	echo " <div class='div_cliente' style='xmargin-left:10em; xborder-bottom:1px solid #C0C0C0;;'>";
	echo " <div class='' style='margin:15px; color:#666666;'>";
	// echo " <div><span style='color:#0000FF;'>Cliente:</span> {$cpf} - {$nome_cliente} </div>";
	echo " <div><span style='color:#0000FF;'>Evento :</span> {$codigo} - {$descricao} </div>";
	echo " <div><span style='color:#0000FF;'>Período:</span> {$dt_previsao_inicial} de {$dt_previsao_fim} </div>";
	echo " </div>";
	//echo " </div>";
	// verifica resposta
	$vet                = $vetEventoAvaliacao[$cpf][$idt_evento];
	$codigo_estrela     = $vet['codigo'];
	$rowa['qtd_pontos'] = $vet['qtd_pontos'];
	$nota_avaliacao     = $vet['nota_avaliacao'];
	$est1 = "imagens/estrelinha.png";
	$est2 = "imagens/estrelinha.png";
	$est3 = "imagens/estrelinha.png";
	$est4 = "imagens/estrelinha.png";
	$est5 = "imagens/estrelinha.png";
	if ($codigo_estrela!="")
	{
	    if (1<=$codigo_estrela)
		{
		    $est1 = "imagens/estrelinha_1.png";
		}
		if (2<=$codigo_estrela)
		{
		    $est2 = "imagens/estrelinha_1.png";
		}
		if (3<=$codigo_estrela)
		{
		    $est3 = "imagens/estrelinha_1.png";
		}
		if (4<=$codigo_estrela)
		{
		    $est4 = "imagens/estrelinha_1.png";
		}
		if (5<=$codigo_estrela)
		{
		    $est5 = "imagens/estrelinha_1.png";
		}
	
	}
	
	echo " <div class='div_estrelinha' style='text-align:center; display:block; padding-left:10px;'>";
	echo " <div id='ava{$idt_evento}' ava='{$codigo_estrela}' class='div2_estrela' style=' float:left;  padding-top:10px;  xborder:1px solid #C0C0C0;'>";
	echo " Clique nas Estrelas para classificar";
	echo " </div>";
	echo " <div class='div1_estrela' style=' float:left; padding-left:10px;  padding-top:10px;  xborder:1px solid blue;'>";
	echo " <div  onclick='return MarcaEstrela(1,{$idt_evento},".'"'.$cpf.'"'.");' style='color:#004080; xfont-size:14px; cursor:pointer; float:left; xpadding-top:20px; xxxpadding-left:11em; padding-right:10px;'>";
	echo " <img id='est1{$idt_evento}'  title='{$estrela1}' class='estrela' src='{$est1}' border='0'>";
	echo " </div>";
	echo " <div onclick='return MarcaEstrela(2,{$idt_evento},".'"'.$cpf.'"'.");' style='color:#004080; xfont-size:14px; cursor:pointer; float:left; xpadding-top:20px; xpadding-left:30px; padding-right:10px;'>";
	echo " <img  id='est2{$idt_evento}' title='{$estrela2}' class='estrela' src='{$est2}' border='0'>";
	echo " </div>";
	echo " <div onclick='return MarcaEstrela(3,{$idt_evento},".'"'.$cpf.'"'.");' style='color:#004080; xfont-size:14px; cursor:pointer; float:left; xpadding-top:20px; xpadding-left:30px; padding-right:10px;'>";
	echo " <img  id='est3{$idt_evento}' title='{$estrela3}' class='estrela' src='{$est3}' border='0'>";
	echo " </div>";
	echo " <div onclick='return MarcaEstrela(4,{$idt_evento},".'"'.$cpf.'"'.");' style='color:#004080; xfont-size:14px; cursor:pointer; float:left; xpadding-top:20px; xpadding-left:30px; padding-right:10px;'>";
	echo " <img  id='est4{$idt_evento}'  title='{$estrela4}' class='estrela' src='{$est4}' border='0'>";
	echo " </div>";
	echo " <div onclick='return MarcaEstrela(5,{$idt_evento},".'"'.$cpf.'"'.");' style='color:#004080; xfont-size:14px; cursor:pointer; float:left; xpadding-top:20px; xpadding-left:30px; padding-right:10px;'>";
	echo " <img  id='est5{$idt_evento}' title='{$estrela5}' class='estrela' src='{$est5}' border='0'>";
	echo " </div>";
	echo " </div>";
	$reg="Clique nesse Botão para registrar a sua Avaliação";
	echo " <div class='div2_estrela' style='xwidth:100%; float:left; padding-left:0.7em; padding-top:10px; padding-bottom:10px; xborder:1px solid red;'>";
	echo " <div title='{$reg}' class='botao_ag_bl' onclick='return RegistrarAvaliacao({$idt_evento},".'"'.$cpf.'"'.");' style=''>";
	echo " <div style='margin:0.4em; '>Registrar</div>";
	
	echo " </div>"; 
	
	echo " </div>";
	echo " </div>";
	
	echo " </div>";
	
	echo "</section>";
	
}

?>
<script>

var totalpontos=0;

$(document).ready(function () {
/*
   objd=document.getElementById('tipo_pessoa_desc');
   if (objd != null)
   {
	   $(objd).css('visibility','hidden');
   }
   objd=document.getElementById('tipo_pessoa');
   if (objd != null)
   {
	   objd.value = "";
	   $(objd).css('visibility','hidden');
   }
*/		   
});
function MarcaEstrela(opcao,idt_evento,cpf)
{
    
	// alert(idt_evento+' --- '+cpf);
	
	DesmarcaAvaliacao(idt_evento);
	
	var id="ava"+idt_evento;
	var img = document.getElementById(id);
	img.setAttribute('ava', opcao);
		
	if (1<=opcao)
	{
	   // desmarca todas
	    totalpontos=0;
	    var id="est1"+idt_evento;
   		var img = document.getElementById(id);
		img.setAttribute('src', 'imagens/estrelinha_1.png');
		

	}
	if (2<=opcao)
	{
	    totalpontos=25;
	    var id="est2"+idt_evento;
		var img = document.getElementById(id);
		img.setAttribute('src', 'imagens/estrelinha_1.png');
	}
	if (3<=opcao)
	{
	    totalpontos=50;
	    var id="est3"+idt_evento;
		var img = document.getElementById(id);
		img.setAttribute('src', 'imagens/estrelinha_1.png');
	 
	}
	if (4<=opcao)
	{
	    totalpontos=75;
	    var id="est4"+idt_evento;
		var img = document.getElementById(id);
		img.setAttribute('src', 'imagens/estrelinha_1.png');
	 
	}
	if (5<=opcao)
	{
	    totalpontos=100;
	    var id="est5"+idt_evento;
		var img = document.getElementById(id);
		img.setAttribute('src', 'imagens/estrelinha_1.png');
	}
    return false;
}
function DesmarcaAvaliacao(idt_evento)
{
    totalpontos=0;
    var id  = "est1"+idt_evento;
	var img = document.getElementById(id);
	img.setAttribute('src', 'imagens/estrelinha.png');
	var id  = "est2"+idt_evento;
	var img = document.getElementById(id);
	img.setAttribute('src', 'imagens/estrelinha.png');
	var id  = "est3"+idt_evento;
	var img = document.getElementById(id);
	img.setAttribute('src', 'imagens/estrelinha.png');
	var id  = "est4"+idt_evento;
    var img = document.getElementById(id);
	img.setAttribute('src', 'imagens/estrelinha.png');	
	var id  = "est5"+idt_evento;
	var img = document.getElementById(id);
	img.setAttribute('src', 'imagens/estrelinha.png');
}
function RegistrarAvaliacao(idt_evento,cpf)
{
	var id  = "ava"+idt_evento;
	var img = document.getElementById(id);
	var ava = $(img).attr('ava');
	if (ava<1 || ava>5)
	{
	    alert("Atenção!\nPor favor, marcar uma Estrelinha.");
		return false;
	}
	
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: 'ajax_atendimento.php' + '?tipo=RegistrarAvaliacaoEstrelinha',
		data: {
			cas: conteudo_abrir_sistema,
			idt_evento: idt_evento,
			cpf       : cpf,
			avaliacao : ava
		},
		success: function (response) {

			if (response.erro != '') {
				alert(url_decode(response.erro));
			}
			else
			{
				alert("Obrigado."+"\n"+"Sua avaliação foi registrada com sucesso!");
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});
    return false;
}
</script>