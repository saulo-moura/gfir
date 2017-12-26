<style>
Input.Botao {
    background:#0066cb;

}

</style>


<?php
$tabela = 'grc_atendimento_gera_agenda';
$id = 'idt';


$onSubmitDep = 'grc_atendimento_gera_agenda_dep()';


$disponibilidade = $_GET['disponibilidade'];
if ($disponibilidade==S)
{
    $_GET['idt0']=$_SESSION[CS]['g_idt_unidade_regional'];
}


        $url_tmp = "conteudo.php?prefixo=inc&menu=grc_agenda_site&origem_tela=painel&cod_volta=grc_presencial_site";
 //       $url_tmp = $pagina."?prefixo={$prefixo_volta}&menu=".$um_registro['volta_menu'].getParametro('prefixo,menu,'.$um_registro['get_pai'])."#lin".$_GET[$um_registro['get_pai']];
        $botao_volta = "self.location = '{$url_tmp}'";
        $botao_acao = "<script type='text/javascript'>self.location = '{$url_tmp}';</script>";


$bt_alterar_lbl = 'Confirmar';


//$TabelaPai   = "db_pir_grc.plu_usuario";
//$AliasPai    = "grc_pu";
//$EntidadePai = "Atendente";
//$idPai       = "id_usuario";

//$CampoPricPai     = "idt_usuario";

//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);



/*
echo "<div style='background:#0000FF; color:#FFFFFF; font-size:14px;'>";
//echo "   {$_SESSION[CS]['gatdesc_idt_unidade_regional']}            <br /> ";
//echo "   {$_SESSION[CS]['gatdesc_idt_natureza']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_projeto']}            <br /> ";
echo "   {$_SESSION[CS]['gatdesc_idt_acao']}            <br /> ";
//echo "   {$_SESSION[CS]['g_gestor_produto']}            <br /> ";
echo "</div'>";
*/

if ($acao=='inc')
{
    // incluir novo registro
	/*
	$datadia = trata_data(date('d/m/Y H:i:s'));
    $dt_geracao'            = $datadia;
    $hora_inicio'           = '08:00';
    $hora_fim'              = '18:00';
    $hora_intervalo_inicio' = '12:00';
    $hora_intervalo_fim'    = '14:00';
	$duracao                 = $duracao;
	*/
	$idt_usuario     = $_SESSION[CS]['g_id_usuario'];   
	$sql_i  = " insert into {$tabela} ";
    $sql_i .= ' (  ';
    $sql_i .= " idt_usuario ";
    $sql_i .= '  ) values ( ';
	$sql_i .= " $idt_usuario ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_gera_agenda = lastInsertId();
	$_GET['id']=$idt_gera_agenda;
	$acao='alt';


}
$idt_atendimento_gera_agenda = $_GET['id'];

        //
	    // BUSCAR DADOS DA PESSOA 
	    //
		
        $idt_ponto_atendimento = $_SESSION[CS]['gat_idt_unidade_regional'];
        $idt_consultor         = $_SESSION[CS]['g_id_usuario'];
		$duracao               = 0;
 	    $sql2  = 'select ';
		$sql2 .= '  a.*, c.idt_servico as idt_servico ';
		$sql2 .= '  from grc_atendimento_pa_pessoa a';
		$sql2 .= '  left outer join grc_atendimento_pa_pessoa_servico c on c.idt_pa_pessoa = a.idt';
		$sql2 .= '  where a.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
		$sql2 .= '  and   a.idt_usuario           = '.null($idt_consultor);
		$rs_aap = execsql($sql2);
		// $row_aap = $rs_aap->data[0];
		if ($rs_aap->rows>0)
		{
			ForEach ($rs_aap->data as $row) {
				$duracao     = $row['duracao'];
				$idt_servico = $row['idt_servico'];
			}
		}
		else
		{
		   echo " Não encontrado Usuário como Consultor ou Atendente para esse PA)";
		   exit();
		
		}
		
 //p($_SESSION[CS]);		
 //p($sql2);





$TabelaPai    = "".db_pir."sca_organizacao_secao";
$AliasPai     = "grc_os";
$EntidadePai  = "Ponto de Atendimento";
$idPai        = "idt";

$CampoPricPai = "idt_ponto_atendimento";

//p($_GET);

//p($_SESSION[CS]);
if ($_GET['idt0']=="")
{
    $_GET['idt0'] = $_SESSION[CS]['gat_idt_unidade_regional'];
	$disponibilidade='S';
//	$_SESSION[CS]['g_id_usuario']
}
$idt_ponto_atendimento   = $_GET['idt0'];
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$js    = " disabled  style='xvisibility:hidden; background:#FFFFD7; font-size:14px;' ";
$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= ' where id_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Usuario', true, $sql,'','width:400px;',$js);

$js    = " readonly='true' style='xvisibility:hidden; background:#FFFFD7; font-size:14px;' ";
$vetCampo['dt_geracao'] = objDataHora('dt_geracao', 'Data Geração', True,$js);

$js    = ' onblur = VerificaData(1); ';
$vetpicker=Array();
$vetpicker['direcao']='F';
$vetpicker['qtd']=2;
$vetCampo['dt_inicial'] = objData('dt_inicial', 'Data Inicial', True,$js,'','S',$vetpicker);

$js    = ' onblur = VerificaData(2); ';
$vetCampo['dt_final']   = objData('dt_final', 'Data Final', True,$js,'','S',$vetpicker);

$js    = ' onblur = VerificaData(3); ';
$vetCampo['data_aleatoria'] = objTexto('data_aleatoria', 'Definir datas Aleatórias', false, 35, 255,$js);


if ($disponibilidade==S)
{
    $sql  = "select plu_us.id_usuario, plu_us.nome_completo from grc_atendimento_pa_pessoa grc_app ";
    $sql .= ' inner join plu_usuario plu_us on plu_us.id_usuario = grc_app.idt_usuario ';
    $sql .= ' where grc_app.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
    $sql .= '   and plu_us.id_usuario             = '.null($_SESSION[CS]['g_id_usuario']);
    $sql .= " order by plu_us.nome_completo";
    $jsm = " disabled='disabled' style='background:#FFFFD7; font-size:14px; width:400px;' ";

    $vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,'','' ,$jsm);
}
else
{
    $sql  = "select plu_us.id_usuario, plu_us.nome_completo from grc_atendimento_pa_pessoa grc_app ";
    $sql .= ' inner join plu_usuario plu_us on plu_us.id_usuario = grc_app.idt_usuario ';
    $sql .= ' where grc_app.idt_ponto_atendimento = '.null($idt_ponto_atendimento);
    $sql .= " order by plu_us.nome_completo";
    $vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor', false, $sql,'Gera agenda de todos os consultores','width:400px;');
}

if ($acao=='inc')
{
    $js    = " readonly='true' style='color:#0000FF; background:#FFFFD7; font-size:14px;' ";
}
else
{
    $js    = " readonly='true' style='background:#FFFFD7; font-size:14px;' ";
}

$vetCampo['botao_atendimento_gera_agenda'] = objInclude('botao_atendimento_gera_agenda', 'cadastro_conf/botao_atendimento_gera_agenda.php');






$js = ' onblur = "VerificaHora(this,1)"  onkeyup="return Formata_Hora(this,event)" ';
$vetCampo['hora_inicio'] = objHora('hora_inicio', 'Hora Inicial', True,'',$js);



$js = ' onblur = "VerificaHoraInt(this,2)"  onkeyup="return Formata_Hora(this,event)" ';
$vetCampo['hora_intervalo_inicio'] = objHora('hora_intervalo_inicio', 'Horário de Intervalo', false,'',$js);
$js = ' onblur = "VerificaHoraInt(this,2)"  onkeyup="return Formata_Hora(this,event)" ';
$vetCampo['hora_intervalo_fim'] = objHora('hora_intervalo_fim', 'Horário Retorno', false,'',$js);


$js = ' onblur = "VerificaHora(this,2)"  onkeyup="return Formata_Hora(this,event)" ';
$vetCampo['hora_fim']    = objHora('hora_fim', 'Horário Final', True,'',$js);




$js = "";
$vetCampo['duracao']    = objInteiro('duracao', 'Duração do Atendimento (Minutos)', true,$js);



$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Justificativa', false, $maxlength, $style, $js);

//$vetCampo['executa']    = objCmbVetor('executa', '<b>O que deseja executar?</b>', false, $vetAgenda, 'Agora não quero executar nada' ,'' ,' width:450px;' );

$vetCampo['executa']    = objCmbVetor('executa', '<b>O que deseja executar?</b>', true, $vetAgenda, ' ' ,'' ,' width:700px;' );



$datadia = trata_data(date('d/m/Y H:i:s'));
$databasevalidade=substr($datadia,0,10);
$horabasevalidade=substr($datadia,11,8);
//echo "  {$datadia}, {$databasevalidade},  {$horabasevalidade}  ";


$sql_lst_1  = 'select grc_ae.idt as idt_servico, grc_ae.descricao ';
$sql_lst_1 .= ' from grc_atendimento_especialidade grc_ae ';
$sql_lst_1 .= ' inner join grc_atendimento_pa_pessoa_servico grc_apps on grc_apps.idt_servico = grc_ae.idt ';
$sql_lst_1 .= ' inner join grc_atendimento_pa_pessoa grc_app on grc_app.idt = grc_apps.idt_pa_pessoa ';
$sql_lst_1 .= ' where grc_app.idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql_lst_1 .= '   and grc_app.idt_ponto_atendimento = '.null($idt_ponto_atendimento);

$sql_lst_1 .= '   and ( grc_ae.data_despublicar is null or (grc_ae.data_despublicar >= '.aspa($databasevalidade);
$sql_lst_1 .= '   and grc_ae.data_despublicar >= '.aspa($horabasevalidade).' ) ) ';


$sql_lst_1 .= ' order by descricao';



$sql_lst_2 = 'select ds.idt as idt_servico, ds.descricao from grc_atendimento_especialidade ds inner join
               grc_atendimento_gera_agenda_servico dr on ds.idt = dr.idt_servico
               where dr.idt = '.null($_GET['id']).' order by ds.descricao';
			   
			   
			   
$vetCampo['idt_servico'] = objLista('idt_servico', false, 'Serviços SEBRAE', 'idt_servico1', $sql_lst_1, 'grc_atendimento_gera_agenda_servico', 310, 'Serviços Selecionados', 'idt_servico2', $sql_lst_2);

//function objInclude($campo, $arquivo, $vetVariavel = Array()) {

$html   = "<div style='padding-top:10px;'>";
$html  .= " Instruções: ";
$html  .= "<br />";
$html  .= "Separe com ponto e vírgula os dias e/ou com hífem os intervalos de dias do mês selacionado.<br />";
$html  .= "Ex.: 1;8; 10-12 irá gerar as agendas para os dias 1,8, 10, 11 e 12 do mês selecionado.";
$html  .= "</div>";

$vetCampo['horario_semanal'] = objCheckbox('horario_semanal', '', 'S', 'N', 'Horário Semanal', true, 'N');
 

$vetCampo['comentario_data_variavel'] = objInclude('comentario_data_variavel', $html  );


$vetCampo['botao_gera_agenda_mostra'] = objInclude('botao_gera_agenda_mostra', 'cadastro_conf/botao_gera_agenda_mostra.php');

$par = 'idt_servico';
$vetDesativa['executa'][0]   = vetDesativa($par, 'Gera', false);
$vetAtivadoObr['executa'][0] = vetAtivadoObr($par, 'Gera', true, '_lst_2');

$vetFrm = Array();

/*
MesclarCol($vetCampo[$CampoPricPai], 9);
MesclarCol($vetCampo['idt_consultor'], 9);
MesclarCol($vetCampo['observacao'], 9);
MesclarCol($vetCampo['data_aleatoria'], 5);

MesclarCol($vetCampo['executa'], 9);
*/

//MesclarCol($vetCampo[$CampoPricPai], 7);
//MesclarCol($vetCampo['idt_consultor'], 7);
//MesclarCol($vetCampo['observacao'], 7);
//MesclarCol($vetCampo['data_aleatoria'], 5);

//MesclarCol($vetCampo['executa'], 3);
//MesclarCol($vetCampo['observacao'], 3);

MesclarCol($vetCampo['comentario_data_variavel'], 7);

MesclarCol($vetCampo['botao_gera_agenda_mostra'], 11);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_consultor'],'',$vetCampo[$CampoPricPai]),
    //Array($vetCampo['idt_consultor']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['hora_inicio'],'',$vetCampo['hora_intervalo_inicio'],'',$vetCampo['hora_intervalo_fim'],'',$vetCampo['hora_fim'],'',$vetCampo['dt_inicial'],'',$vetCampo['dt_final']),
    Array($vetCampo['horario_semanal'],'',$vetCampo['data_aleatoria'],'',$vetCampo['comentario_data_variavel']),
	
	Array($vetCampo['botao_gera_agenda_mostra']),	
 ),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('', Array(
   // Array($vetCampo['idt_servico'],'',$vetCampo['duracao']),
    Array($vetCampo['executa']),
    Array($vetCampo['idt_servico']),
	Array($vetCampo['observacao']),
	
	
),$class_frame,$class_titulo,$titulo_na_linha);




if ($acao=='inc' )
{
	$vetFrm[] = Frame('<span>Controle</span>', Array(
		Array($vetCampo['idt_usuario'],'',$vetCampo['dt_geracao']),
	),$class_frame,$class_titulo,$titulo_na_linha);
}
$vetCad[] = $vetFrm;
?>

<script>

   var idt_atendimento_gera_agenda =  <?php echo $idt_atendimento_gera_agenda;  ?>

   $(document).ready(function () {
         $('#dt inicial, #dt_final').change(function () {
           // valida_dt();
        });
     });

 
function valida_dt() {
        if (validaDataMaior(false, $('#dt_final'), 'Data Final', $('#dt inicial'), 'Data Inicial') === false) {
            $('#dt_final').val('');
            $('#dt_final').focus();
            return false;
        }

        /*
         if (newDataHoraStr(false, $('#filtro_dt_fim').val()) - newDataHoraStr(false, $('#filtro_dt_ini').val()) >= (diasint * 24 * 60 * 60 * 1000)) {
         alert('O intervalo entre as datas não pode ser superior a ' + diasint + ' dias!');
         $('#filtro_dt_fim').val('');
         $('#filtro_dt_fim').focus();
         return false;
         }
         */
    }


function VerificaData(opcao)
{
   
	var id_ini = "#dt_inicial";
	var id_fim = "#dt_final";
	
	var id_data_aleatoria = "#data_aleatoria";
	
	//var dt_ini = $('id_ini').val('');
	//var dtfim  = $('id_fim').val('');
	
	var dt_ini  = $(id_ini).val();
	var dt_fim  = $(id_fim).val();

	//alert('Data Final tem que ser maior '+dt_fim+' ou Igual a data Inicial '+dt_ini);
	
	if (validaDataMaior(false, $(id_fim), 'Data Final', $(id_ini), 'Data Inicial') === false) {
		$(id_fim).val('');
		$(id_fim).focus();
		alert('Data Final tem que ser maior ou Igual a data Inicial');
		return false;
	}
	//alert (' opcao = '+opcao);
	if (opcao!=3)
	{
		//$(id_fim).focus();
	}
	else
	{
	
	
		var str_data_aleatoria = $(id_data_aleatoria).val();
		
		if (str_data_aleatoria!="")
		{
			//alert('Data Aleatória '+str_data_aleatoria);
			$.ajax({
				dataType: 'json', 
				type: 'POST',
				url: ajax_sistema + '?tipo=data_aleatoria',
				data: {
					cas: conteudo_abrir_sistema,
					dt_ini : dt_ini,    
					dt_fim : dt_fim, 
					str_data_aleatoria: str_data_aleatoria
				},
				success: function (response) {
					if (response.erro == '') {
						alert(url_decode(response.datasgeradas));
					} else {
						alert(url_decode(response.erro));
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
				},
				async: true
			});
	    }	
	}

	return true;
}
function VerificaHora(thisw,opcao)
{
    if (opcao==99)
	{
	
	}
	else
	{
		if (!Valida_Hora(thisw))
		{
			return false;
		}
	}
	id_ini      = "#hora_inicio";
	id_fim      = "#hora_fim";
	
	var ho_ini  = $(id_ini).val();
	var ho_fim  = $(id_fim).val();
	
	var vhh     = ho_ini.split(':');
	var hh_ini  = vhh[0];
	var mm_ini  = vhh[1];
	var vhh     = ho_fim.split(':');
	var hh_fim  = vhh[0];
	var mm_fim  = vhh[1];
	
	
	hhmmini = hh_ini + (mm_ini * 60);
	hhmmfim = hh_fim + (mm_fim * 60);
	if (opcao==99)
	{
		if (ho_ini!="" && ho_fim!="")
		{
		     // esat ok
		}
		else
		{
			if (ho_ini!="" && ho_fim=="")
			{
				 // esat ok
				 alert('Hora Inicial informada. Tem que informar a  Final');
			}
			if (ho_ini="" && ho_fim!="")
			{
				 // esat ok
				 alert('Hora Final informada. Tem que informar a Inicial');
			}
		
		
		}
	}
	
	
	if (ho_ini!="" && ho_fim!="")
	{
		if (hhmmfim >= hhmmini )
		{
		}
		else
		{
		   alert ('Hora Inicial tem que ser Menor ou Igual a Hora Final');
		   //$(id_ini).focus();
		   return false; 	   
		}
		
	}
	if (VerificaHoraInt(thisw,opcao)==false)
		{
		    return false;
		}
    return true; 

}
function VerificaHoraInt(thisw,opcao)
{
    if (opcao==99)
	{
	
	}
    else
	{
		if (!Valida_Hora(thisw))
		{
			return false;
		}
	}
	id_ini      = "#hora_intervalo_inicio";
	id_fim      = "#hora_intervalo_fim";
	
	var ho_ini  = $(id_ini).val();
	var ho_fim  = $(id_fim).val();
	
	var vhh     = ho_ini.split(':');
	var hh_ini  = vhh[0];
	var mm_ini  = vhh[1];
	var vhh     = ho_fim.split(':');
	var hh_fim  = vhh[0];
	var mm_fim  = vhh[1];
	
	
	hhmmini = hh_ini + (mm_ini * 60);
	hhmmfim = hh_fim + (mm_fim * 60);
	
	
	if (opcao==99)
	{
		if (ho_ini!="" && ho_fim!="")
		{
		     // esat ok
		}
		else
		{
			if (ho_ini!="" && ho_fim=="")
			{
				 // esat ok
				 alert('Hora de Intervalo Inicial informada. Tem que informar a Hora de Retorno do Intervalo');
			}
			if (ho_ini="" && ho_fim!="")
			{
				 // esat ok
				 alert('Hora de Retorno do Intervalo informada. Tem que informar a Hora Inicial Intervalo ');
			}
		
		
		}
	}
	
	
	if (ho_ini!="" && ho_fim!="")
	{
		if (hhmmfim >= hhmmini )
		{
		}
		else
		{
		   alert ('Hora Intervalo Inicial tem que ser Menor ou Igual a Hora Intervalo Retorno');
		   $(id_ini).focus();
		   return false; 	   
		}
	}
	
	id_ini      = "#hora_inicio";
	id_fim      = "#hora_fim";
	
	var ho_init  = $(id_ini).val();
	var ho_fimt  = $(id_fim).val();
	
	var vhh     = ho_init.split(':');
	var hh_ini  = vhh[0];
	var mm_ini  = vhh[1];
	var vhh     = ho_fimt.split(':');
	var hh_fim  = vhh[0];
	var mm_fim  = vhh[1];
	
	// A Total Inicio e fim
	hhmminit = hh_ini + (mm_ini * 60);
	hhmmfimt = hh_fim + (mm_fim * 60);
	
	
	if (ho_ini!="" && ho_fim!="" && ho_init!="" && ho_fimt!="")
	{
		if (hhmmini >= hhmminit  )
		{
		}
		else
		{
		   alert ('Hora Inicial Intervalo tem que ser Maior ou Igual a Hora Inicial');
		   //$(id_ini).focus();
		   return false; 	   
		}
		if (hhmmfimt >= hhmmfim  )
		{
		}
		else
		{
		   alert ('Hora Final Intervalo tem que ser Menor ou Igual a Hora Final');
		   //$(id_ini).focus();
		   return false; 	   
		}
	}
//alert ('---'+ho_ini+'---'+ho_init+'---w'+hhmmini+'---w'+hhmminit);
	if (ho_ini!="" &&  ho_init!="" )
	{
		if (hhmmini >= hhmminit  )
		{
		}
		else
		{
		   alert ('Hora Inicial Intervalo tem que ser Maior ou Igual a Hora Inicial');
		   
		   //$(id_ini).focus();
		   return false; 	   
		}
		
	}
	if (ho_fim!="" &&  ho_fimt!="" )
	{
		if (hhmmfimt >= hhmmfim  )
		{
		}
		else
		{
		   alert ('Hora Final Intervalo tem que ser Menor ou Igual a Hora Final');
		   //$(id_ini).focus();
		   return false; 	   
		}
	}

	
	
	
    return true; 

}


function grc_atendimento_gera_agenda_dep() {
    var opcao=99;
	var thisw=0;
    var ret1 = VerificaHora(thisw,opcao);
    var ret2 = VerificaHoraInt(thisw,opcao);	
	if (ret1==false)
	{
	    return false;
	}
	if (ret2==false)
	{
	    return false;
	}
    var executa         = "#executa";
	var data_aleatoria  = "#data_aleatoria";
	var valexecuta      = $(executa).val();
	var data_aleatoria  = $(data_aleatoria).val();
	if (data_aleatoria!="")
	{
	    var msg = "";
	    msg = msg+"Atenção!"+"\n";
		msg = msg+"Será considerada Opção de Datas Aleatórias."+"\n";
		msg = msg+"Confirma?"+"\n";
		if (!confirm(msg))
		{
		    return false;
		}	
	
	}
	if (valexecuta=='Gera')
	{
	/*    
	    var idt_atendimento_agenda   = "#idt_atendimento_agenda";
		var dt_inicial            = "#dt_inicial";
		var dt_final              = "#dt_final";
		var idt_consultor         = "#idt_consultor";
		var idt_ponto_atendimento = "#idt_ponto_atendimento";
		var hora_inicio           = "#hora_inicio";
		var hora_fim              = "#hora_fim";
		
		var hora_intervalo_inicio = "#hora_intervalo_inicio";
		var hora_intervalo_fim    = "#hora_intervalo_fim";
		
		var idt_servico           = "#idt_servico";
		var data_aleatoria        = "#data_aleatoria";
		var observacao            = "#observacao";
		
		
		var idt_atendimento_agenda = 0;
		var dt_inicial  = $(dt_inicial).val();
		var dt_final    = $(dt_final).val();
		
        var idt_consultor    = $(idt_consultor).val();
		var idt_ponto_atendimento    = $(idt_ponto_atendimento).val();
		var hora_inicio    = $(hora_inicio).val();
		var hora_fim    = $(hora_fim).val();
		var hora_intervalo_inicio   = $(hora_intervalo_inicio).val();
		var hora_intervalo_fim   = $(hora_intervalo_fim).val();
		
		var idt_servico   = $(idt_servico).val();
		var data_aleatoria   = $(data_aleatoria).val();
		var observacao   = $(observacao).val();
        var volta = "N";
       // alert('bbbbb '+dt_inicial);	
		$.ajax({
			dataType: 'json', 
			type: 'POST',
			url: ajax_sistema + '?tipo=CarregarAgendaExistente',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_gera_agenda : idt_atendimento_gera_agenda,
				dt_inicial : dt_inicial,    
				dt_final : dt_final, 
				idt_consultor : idt_consultor, 
				idt_ponto_atendimento : idt_ponto_atendimento, 
				hora_inicio : hora_inicio, 
				hora_fim : hora_fim, 
				hora_intervalo_inicio : hora_intervalo_inicio, 
				hora_intervalo_fim : hora_intervalo_fim, 
				idt_servico : idt_servico, 
				data_aleatoria : data_aleatoria, 
				observacao : observacao 
			},
			success: function (response) {
				if (response.erro == '') {
				    if (response.existeagenda == 'N') {
					   // Não tem agenda Procede como de primeira vez
	                }
					else					
					{
					//Ext.Msg.alert('Status', 'Changes saved successfully.');

					
					    // Questiona
						var r = confirm("Para o Periodo informado Existem Registros na sua Agenda."+"\n"+"Deseja Verificar os Existentes?");
						if (r == false) {
							// Parar a OPERAção - Desistir e voltar a tela sem fazer nada.
							//return false;
							volta = "N";
							
						} else {
						    volta = "S";
							// Agora perguntar se deseja apagar ou não
							
						//	var r = confirm("Deseja Apagar os Existentes e criar NOVOS com a parametrização informada agora?."+"\n"+"Atenção!\nSe confirmar os Existentes e DISPONIVEL serão apagados. Confirma?");
						//	if (r == true) {
						//		// apagar os existentes
						//	} else {
						//		// Prosseguir como é Hoje
						//	}
						    var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Agenda do Período</div>";
							var parww   = '&idt_atendimento_agenda='+idt_atendimento_agenda+'&deondeveio=Distancia'+'&titulo_rel='+titulo;  
							var href    = 'conteudo_agenda_ex.php?prefixo=inc&menu=agenda_ex'+parww; 
		
							var  height = $(window).height(); 
							var  width  = $(window).width(); 
							
							var  height = 600; 
							var  width  = 900; 
							
							showPopWin(href, titulo , width, height, close_ChamaFuncao1,true,20);
														
							var  left   = 0; 
							var  top    = 0; 
							var  height = $(window).height(); 
							var  width  = $(window).width();  
							var ImpComp = window.open(href,'ImpComp','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 
							
						}
					}	
				} else {
					alert(url_decode(response.erro));
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
			},
			async: false
		});		
		
	*/	
		
		
	}
	if (valexecuta=='Exclui')
	{
	    //alert(valexecuta);
	}
	if (valexecuta=='Bloqueia')
	{
	    //alert(valexecuta);
		//MostraResultado();
	}
	if (valexecuta=='Agenda')
	{
	    //alert(valexecuta);
		//MostraResultado();
	}
		
//	alert('to me picando '+ volta);
	
	//if (volta=="S")
	//{
	//    return false;
	//}
	return true;
}



function MostraResultado(idt_atendimento_gera_agenda)
{
      //  alert('teste de guy');
	    var idt_atendimento_agenda   = "#idt_atendimento_agenda";
		var dt_inicial            = "#dt_inicial";
		var dt_final              = "#dt_final";
		var idt_consultor         = "#idt_consultor";
		var idt_ponto_atendimento = "#idt_ponto_atendimento";
		var hora_inicio           = "#hora_inicio";
		var hora_fim              = "#hora_fim";
		
		var hora_intervalo_inicio = "#hora_intervalo_inicio";
		var hora_intervalo_fim    = "#hora_intervalo_fim";
		
		var idt_servico           = "#idt_servico";
		var data_aleatoria        = "#data_aleatoria";
		var observacao            = "#observacao";
		
		
		var idt_atendimento_agenda = 0;
		var dt_inicial  = $(dt_inicial).val();
		var dt_final    = $(dt_final).val();
		
        var idt_consultor    = $(idt_consultor).val();
		var idt_ponto_atendimento    = $(idt_ponto_atendimento).val();
		var hora_inicio    = $(hora_inicio).val();
		var hora_fim    = $(hora_fim).val();
		var hora_intervalo_inicio   = $(hora_intervalo_inicio).val();
		var hora_intervalo_fim   = $(hora_intervalo_fim).val();
		
		var idt_servico   = $(idt_servico).val();
		var data_aleatoria   = $(data_aleatoria).val();
		var observacao   = $(observacao).val();
        var volta = "N";
        // alert('bbbbb '+dt_inicial);	
		$.ajax({
			dataType: 'json', 
			type: 'POST',
			url: ajax_sistema + '?tipo=CarregarAgendaExistente_dep',
			data: {
				cas: conteudo_abrir_sistema,
				idt_atendimento_gera_agenda : idt_atendimento_gera_agenda
				 
			},
			success: function (response) {
				if (response.erro == '') {
				    if (response.existeagenda == 'N') {
					   // Não tem agenda Procede como de primeira vez
					      //     alert('bbbbb 1 '+dt_inicial);	

	                }
					else					
					{
					    //    alert('bbbbb 222 '+dt_inicial);	

					    // Questiona
						var r = confirm("Deseja ver o Resultado da Operação?"+"\n"+"");
						if (r == false) {
							// Parar a OPERAção - Desistir e voltar a tela sem fazer nada.
							//return false;
							volta = "N";
							
						} else {
						    volta = "S";
							// Agora perguntar se deseja apagar ou não
						    var titulo  = "<div style='xwidth:700px; display:block; text-align:center; '>Agenda do Período</div>";
							var parww   = '&idt_atendimento_gera_agenda='+idt_atendimento_gera_agenda+'&deondeveio=ag'+'&titulo_rel='+titulo;  
							var href    = 'conteudo_agenda_ex.php?prefixo=inc&menu=agenda_ex'+parww; 
		
							var  height = $(window).height(); 
							var  width  = $(window).width(); 
							
							var  height = 600; 
							var  width  = 900; 
							
					//		showPopWin(href, titulo , width, height, close_ChamaFuncao1,true,20);
														
							var  left   = 0; 
							var  top    = 0; 
							var  height = $(window).height(); 
							var  width  = $(window).width();  
							var MAg = window.open(href,'MAg','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); 
							
						}
					}	
				} else {
					alert(url_decode(response.erro));
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
			},
			async: false
		});		
}
</script>
