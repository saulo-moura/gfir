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

$TabelaPrinc      = "grc_atendimento_agenda";
$AliasPric        = "grc_aa";
$Entidade         = "Agenda";
$Entidade_p       = "Agendas";


$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';




//$bt_print          = false;

//listar_rel_exportar('')



$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

// $barra_inc_img = "imagens/agenda_nova.png";
// $barra_alt_img = "imagens/agenda_alterar.png";
// $barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Incluir um Novo Agendamento';
$barra_alt_h = 'Alterar o Agendamento';
$barra_con_h = 'Consultar o Agendamento';

// p($_GET);
// p($_SESSION[CS]);

 $veio = $_GET['veio'];
 

if ($veio==10)
{
    // $vetBtBarra[] = vetBtBarra('', 'Chamar Próximo da fila', 'imagens/chamar_proximo.png', 'Chamar_Proximo()', '');
}


echo "<div class='cab_1_1' >";
echo "  RELATÓRIO DE AGENDAMENTO";


$recepcao=$_GET['recepcao'];
$_SESSION[CS]['fu_recepcao'] = $recepcao;
if ($recepcao==1)
{
  echo "  ATENDIMENTO DE RECEPÇÃO";
}
$balcao                   = $_GET['balcao'];
if ($balcao!='')
{

  $_SESSION[CS]['fu_balcao']="";

}

if ($_SESSION[CS]['fu_balcao']=="")
{
     $_SESSION[CS]['fu_balcao'] = $balcao;
}
else
{
    $balcao                   = $_SESSION[CS]['fu_balcao'];

}

//
// Onde estou e quem sou
//
$idt_ponto_atendimento_login = "";
$idt_consultor_login         = "";
$nome_ponto_atendimento_login = $_SESSION[CS]['gdesc_idt_unidade_regional'];
$nome_consultor_login         = $_SESSION[CS]['g_nome_completo'];
//echo "  ATENDIMENTO veio {$veio} ";
echo "<div class='cab_1_1' >";
if ($balcao==1)
{
    echo "  ATENDIMENTO DE BALCAO";
}
 if ($veio==1)
 {
    echo "  MINHA AGENDA";
 }
 if ($veio==2)
 {
    echo "  CRIAR NOVA AGENDA";
 }
 if ($veio==3)
 {
    echo "  AGENDAR CLIENTE";
 }
 if ($veio==4)
 {
    echo "  PESQUISAR";
 }
 if ($veio==5)
 {
    echo "  EMITIR COMPROVANTE";
 }
 if ($veio==6)
 {
    echo "  VISUALIZAR PARA IMPRESSÃO";
 }
 if ($veio==20)
 {  // pesquisar cliente
    echo "  PESQUISAR CLIENTE - AGENDAMENTO";
 }


//echo "<br />vvvvvvvvvvvvvv {$veio} <br />";


 //$idbotaopasso = $TabelaPrinc.$veio;
 $idbotaopasso = $TabelaPrinc;

 $tembotaopasso="";
 // Gestão de Filas
 if ($veio==10 or $veio==13)
 {  // chama proximo cliente
 // $tituloveio = "  CHAMAR PRÓXIMO CLIENTE ";
 
  $tituloveio = "  FILAS DE CHAMADA ";
  $tembotaopasso="S";

  $prefixow='inc';
  $mostrar    = true;
  $cond_campo = '';
  $cond_valor = '';
  //$veio = "D";
  $direito_geral=1;
  $comidentificacao  = 'A';

 // $bt_print  = true;


 
  
  $imagem  = 'imagens/remover.png';
  $goCad[] = vetCad('idt', 'Cancelar a Senha de Atendimento', 'grc_remove_senha_fila', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


  $imagem  = 'imagens/cadastro_clientes.png';
  $goCad[] = vetCad('idt', 'Cadastro de Clientes', 'grc_chama_cadastro_cliente', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


  if ($veio==10)
  {  // chama proximo cliente
      $imagem  = 'imagens/chamar_cliente.png';
      $goCad[] = vetCad('idt', 'Chamar Cliente para Atendimento', 'grc_chama_cliente_fila', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
  }
 }
 if ($veio==11)
 {  // chama proximo cliente
    $tituloveio = "  VISUALIZAR PARA IMPRESSÃO ";
    $tembotaopasso="S";
 }
 if ($veio==13)
 {  // chama proximo cliente
    $tituloveio = "  CONFIRMAR PRESENÇA ";
    $tembotaopasso="S";
 }
 if ($veio==14)
 {  // pesquisar cliente
    $tituloveio = "  PESQUISAR CLIENTE - FILA DE ATENDIMENTO";
    $tembotaopasso="S";
 }

 if ($veio==20)
 {  // pesquisar cliente
    $tituloveio = "  PESQUISAR CLIENTE - AGENDAMENTO ";
    $tembotaopasso="S";
 }

 if ($veio==10 or $veio==11 or $veio==13 or $veio==14)
 {  // chama proximo cliente
  $tembotaopasso="S";
  $datahoje         = date('d/m/Y');
  $dia_semana       = GRC_DiaSemana($datahoje,'resumo1');   // formato dd/mm/aaaa
  echo "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
  echo "<tr>  ";
  echo "<td colspan='2' class='T_titulo'>";
  echo $tituloveio;
  echo "</td>";
  echo "</tr>  ";

  echo "<tr>  ";
  echo "<td class='L_titulo'>";
  echo "  Ponto de Atendimento : ".$_SESSION[CS]['gdesc_idt_unidade_regional'];
  echo "</td>";
  echo "<td class='L_titulo'>";
  echo $datahoje." - ".$dia_semana;
  echo "</td>";
  echo "</tr>  ";
  echo "</table>";

 }


// echo " veio == $veio ------------------ ";


echo "</div>";

 
$callcenter=$_GET['callcenter'];
$_SESSION[CS]['fu_callcenter'] = $callcenter;
if ($callcenter==1)
{
  /// echo "  ATENDIMENTO EM CALL CENTER";
}



echo "</div>";


$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


// Descida para o nivel 2

$prefixow   = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';


/*
$imagem  = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt', 'Ocorrência', 'grc_atendimento_agenda_ocorrencia', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
*/
 $fixaunidade   = 0;
 $fixaconsultor = 0;
 $tipo_agenda = 0;
 //$delayinicial = '+45 day';

 $delayinicial = '+2 day';


 if ($veio==1)
 {   // Minha Agenda
     $tipo_agenda   = $veio;
     $comfiltro     = 'A';
     $fixaunidade   = 1;
     $fixaconsultor = 1;
     $delayinicial = '+30 day';
	 $delayinicial = '+2 day';
	 
     $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
     $idt_consultor         = $_SESSION[CS]['g_id_usuario'];
     
     
//     echo " ---------------------------------------------- $idt_ponto_atendimento   ";
     
     
 }
 if ($veio==4)
 {   // imprimir comprovante
     $tipo_agenda   = $veio;
     $comfiltro     = 'A';
     $barra_inc_ap = false;
     $barra_alt_ap = false;
     $barra_con_ap = true;
     $barra_exc_ap = false;
     $barra_fec_ap = false;

 }
 if ($veio==5)
 {   // imprimir comprovante
     $tipo_agenda   = $veio;
     $comfiltro     = 'A';
     $barra_inc_ap = false;
     $barra_alt_ap = false;
     $barra_con_ap = true;
     $barra_exc_ap = false;
     $barra_fec_ap = false;

 }
 if ($veio==6)
 {   // visualizar para impressão
     $tipo_agenda   = $veio;
     $comfiltro     = 'A';
     $barra_inc_ap = false;
     $barra_alt_ap = false;
     $barra_con_ap = true;
     $barra_exc_ap = false;
     $barra_fec_ap = false;

 }
 //
 if ($veio==10)
 {  // chama proximo cliente
    $tipo_agenda   = $veio;
    $comfiltro     = 'F';
    $fixaunidade   = 1;
    $fixaconsultor = 0;
    $delayinicial = '+0 day';
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    //$idt_consultor         = $_SESSION[CS]['g_id_usuario'];
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
    $comcontrole=1;
    $contlinfim  = "Existem #qt Clientes na Fila";
    $comfiltro   = 'N';
    $tipofiltro  = 'N';
	$comfiltro   = 'S';
	$tipofiltro  = 'S';


 }
 
 if ($veio==11)
 {  // Visualizar para Impressão
    $tipo_agenda   = $veio;
    $comfiltro     = 'F';
    $fixaunidade   = 1;
    $fixaconsultor = 0;
    $delayinicial = '+0 day';
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    //$idt_consultor         = $_SESSION[CS]['g_id_usuario'];
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
    $comcontrole=0;
    $contlinfim  = "Existem #qt Clientes na Fila";
    $bt_print=true;
 }


 if ($veio==13)
 {  // confirmar Presença
    $tipo_agenda   = $veio;
    $comfiltro     = 'A';
    $fixaunidade   = 1;
    $fixaconsultor = 0;
    $delayinicial = '+0 day';
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    //$idt_consultor         = $_SESSION[CS]['g_id_usuario'];
    $barra_inc_ap = false;
    $barra_alt_ap = true;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
    $comcontrole=1;
    $contlinfim  = "Existem #qt Clientes na Fila";
    $comfiltro   = 'A';
    $tipofiltro  = 'S';


 }



 if ($veio==14)
 {  // PESQUISAR CLIENTE - GESTÃO DE FILA
    $tipo_agenda   = $veio;
    $comfiltro     = 'A';
    $fixaunidade   = 1;
    $fixaconsultor = 0;
    $delayinicial = '+0 day';
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    //$idt_consultor         = $_SESSION[CS]['g_id_usuario'];
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
    $comcontrole=0;
    $contlinfim  = "Existem #qt Clientes na Fila";

 }

 if ($veio==20)
 {  // PESQUISAR CLIENTE agendamento
    $tipo_agenda   = $veio;
    $comfiltro     = 'A';
    //$fixaunidade   = 1;
	$fixaunidade   = 1;
    $fixaconsultor = 0;
    $delayinicial = '+0 day';
    $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
    //$idt_consultor         = $_SESSION[CS]['g_id_usuario'];
    $barra_inc_ap = false;
    $barra_alt_ap = false;
    $barra_con_ap = false;
    $barra_exc_ap = false;
    $barra_fec_ap = false;
    $comcontrole=0;
    $contlinfim  = "Existem #qt Agendamentos";
  //  echo "  $idt_ponto_atendimento <br />"; 
 }

 
 
//echo " ---- veio ---------    $veio ----- $fixaunidade ---- $fixaconsultor";
 
 
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
	if ($veio==20)
	{   // PESQUISAR CLIENTE agendamento
	    // pegar a classificação do Ponto de atendimento fixado
		$sqlUR  = "select classificacao   ";
		$sqlUR .= " from ".db_pir."sca_organizacao_secao as sos";
        $sqlUR .= ' where ';
		$sqlUR .= ' sos.idt = '.null($idt_ponto_atendimento);
	    $rsUR   = execsql($sqlUR);
		$classificacao_unidade="";
		if ($rsUR->rows <= 0 )
		{
		    // erro, reportar
		}
		else
		{
			foreach ($rsUR->data as $rowUR)
			{
				$classificacao_unidade = substr( $rowUR['classificacao'],0,5) . "%";
			}	
        }
		$classificacao_unidade_uain = "22.01";
		$sql   = 'select ';
		$sql  .= '   idt, descricao  ';
		$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
		$sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S') ";
		$sql  .= " and ( substring(sac_os.classificacao,1,5) like ".aspa($classificacao_unidade);
		$sql  .= " or  substring(sac_os.classificacao,1,5) like ".aspa($classificacao_unidade_uain)." ) ";
		
		$sql  .= ' order by classificacao desc';
    }
	ELSE
	{
		$sql   = 'select ';
		$sql  .= '   idt, descricao  ';
		$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
		$sql  .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
		$sql  .= "   and idt = ".null($idt_ponto_atendimento);
		$sql  .= ' order by classificacao ';
	}
}
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



/*
$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao ";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'idt';
$Filtro['js_tam']    = '0';
$Filtro['LinhaUm']   = '-- Selecione a Especialidade --'; 
$Filtro['nome']      = 'Especialidade';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['idt_especialidade'] = $Filtro;
*/

if ($fixaconsultor==0)
{

    // aqui deve ser todos os usuários da unidade
	
	
	
	
    $sql  = "select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
	
	$sql .= " inner join grc_atendimento_pa_pessoa grc_app on grc_app.idt_usuario = plu_usu.id_usuario ";
	
	$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = grc_app.idt_ponto_atendimento ";
    //	
	// $sql  .= " left join ".db_pir."sca_organizacao_secao as sosUR on substring(sosUR.classificacao,1,5) = substring(sos.classificacao,1,5) ";
	
	$sql .= " where sos.idt = ".null($vetFiltro['ponto_atendimento']['valor']);
    //$sql .= " inner join grc_atendimento_usuario_especialidade grc_aue on grc_aue.idt_usuario = plu_usu.id_usuario ";
	
	
	
	
    //if ($vetFiltro['idt_especialidade']['valor']>0)
    //{
    //    $sql .= " where grc_aue.idt_atendimento_especialidade = ".null($vetFiltro['idt_especialidade']['valor']);
    //}
    $sql .= " order by plu_usu.nome_completo";
}
else
{
    $sql  = "select distinct plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
    $sql .= " where plu_usu.id_usuario = ".null($idt_consultor);
}

$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'id_usuario';
$Filtro['js_tam']    = '0';
//echo " $veio -------------- $fixaconsultor ";
if ($veio==20)
{
$Filtro['LinhaUm']   = '-- Selecione o Consultor --';
}
else
{
	if ($fixaconsultor==0)
	{
		$Filtro['LinhaUm']   = '-- Selecione o Consultor --';
	}
	else
	{
		//$Filtro['LinhaUm']   = $idt_consultor;
	}
}
$Filtro['nome']      = 'Consultores';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['idt_consultor'] = $Filtro;

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

$Filtro['vlPadrao']  = Date('d/m/Y', strtotime($delayinicial));


$Filtro['js']        = 'data';
$Filtro['nome']      = 'Data Final';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;

$vetTipoAgenda=Array();
$vetTipoAgenda['T']='Todos';
$vetTipoAgenda['Agendado']  = 'Disponível';
$vetTipoAgenda['Marcado']   = 'Marcado';
$vetTipoAgenda['Bloqueado'] = 'Bloqueado';

$Filtro = Array();
$Filtro['rs']        = $vetTipoAgenda;
$Filtro['id']        = 'tipoagenda';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Status';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['tipoagenda'] = $Filtro;


$vetSimNaow=Array();
$vetSimNaow['S']="Considera Intervalo de Datas";
$vetSimNaow['N']="Não Considera  Intervalo de Datas";
$Filtro = Array();
$Filtro['rs']        = $vetSimNaow;
$Filtro['id']        = 'consgetadatas';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Consderar Datas?';
$Filtro['valor']     = trata_id($Filtro); 
$vetFiltro['consgetadatas'] = $Filtro;

if ($veio==10)
{
$vetTipoFila=Array();
$vetTipoFila['T']  = 'Todas';
$vetTipoFila['HM'] = 'Hora Marcada';
$vetTipoFila['HE'] = 'Hora Extra Convencional';
$vetTipoFila['HP'] = 'Hora Extra Prioritária';

$Filtro = Array();
$Filtro['rs']        = $vetTipoFila;
$Filtro['id']        = 'tipoFila';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Tipo de Fila';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['tipofila'] = $Filtro;
}

$vetDiaSemana=Array();
$vetDiaSemana['Tod']='Todos';
$vetDiaSemana['Seg']='Segunda';
$vetDiaSemana['Ter']='Terça';
$vetDiaSemana['Qua']='Quarta';
$vetDiaSemana['Qui']='Quinta';
$vetDiaSemana['Sex']='Sexta';
$vetDiaSemana['Sáb']='Sábado';
$vetDiaSemana['Dom']='Domingo';

$Filtro = Array();
$Filtro['rs']        = $vetDiaSemana;
$Filtro['id']        = 'diasemana';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Dia da Semana';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['diasemana'] = $Filtro;




    $sql  = "select idt, descricao from grc_atendimento_especialidade ";
    $sql .= " order by descricao ";
    $rs = execsql($sql);
    $Filtro = Array();
    $Filtro['rs']        = $rs;
    $Filtro['id']        = 'idt';
    $Filtro['js_tam']    = '0';
    $Filtro['LinhaUm']   = '-- Todos os Serviços --';
    $Filtro['nome']      = 'Serviço';
    $Filtro['valor']     = trata_id($Filtro);
    $vetFiltro['idt_servico'] = $Filtro;


if ($veio==14777777)
{
    $sql  = "select idt, descricao from grc_atendimento_instrumento ";
    $sql .= " where balcao = 'S'";
    $sql .= " order by descricao ";
    $rs = execsql($sql);
    $Filtro = Array();
    $Filtro['rs']        = $rs;
    $Filtro['id']        = 'idt';
    $Filtro['js_tam']    = '0';
    $Filtro['LinhaUm']   = '-- Selecione o Instrumento --';
    $Filtro['nome']      = 'Instrumento';
    $Filtro['valor']     = trata_id($Filtro);
    $vetFiltro['idt_instrumento'] = $Filtro;
    
    $Filtro = Array();
    $Filtro['rs']        = 'Texto';
    $Filtro['id']        = 'protocolo';
    $Filtro['js_tam']    = '0';
    $Filtro['nome']      = 'Protocolo';
    $Filtro['valor']     = trata_id($Filtro);
    $vetFiltro['protocolo']  = $Filtro;

    
    
}


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



$orderby = "{$AliasPric}.data";




if ($veio==10 or $veio==11 or $veio==13 or $veio==14)
{
   $classer_pard='a_centro';
   //$vetCampo['protocolo'] = CriaVetTabela('Senha','','','',$classer_pard,'',$classer_pard);
   $vetCampo['senha_totem'] = CriaVetTabela('Senha','','','',$classer_pard,'',$classer_pard);
}

if ($veio==14)
{
   $vetCampo['protocolo'] = CriaVetTabela('Protocolo','','','',$classer_pard,'',$classer_pard);
   $vetCampo['ga_situacao'] = CriaVetTabela('Situação','','','',$classer_pard,'',$classer_pard);
}

if ($veio!=10)
{  // chama proximo cliente
    $classer_pard='a_data';
    $vetCampo["data"]    = CriaVetTabela('Data','data','','',$classer_pard,'',$classer_pard);
    $classer_pard='d_data';
    $vetCampo['dia_semana'] = CriaVetTabela('Dia','','','',$classer_pard,'',$classer_pard);
}
$classer_pard='h_data';
$vetCampo["hora"] = CriaVetTabela('Hora','','','',$classer_pard,'',$classer_pard);

$vetCampo['servicos'] = CriaVetTabela('Serviços Disponíveis');
 
$vetTipoAgenda=Array();
$vetTipoAgenda['Agendado']     = 'Disponível';
//$vetTipoAgenda['Marcado']    = 'MARCADO';
//$vetTipoAgenda['Cancelado']  = 'CANCELADO';
$classer_pard='a_centro';
$vetCampo['situacao'] = CriaVetTabela('Status','descDominio',$vetTipoAgenda,'',$classer_pard,'',$classer_pard);

//$vetCampo['situacao'] = CriaVetTabela('Status','','','',$classer_pard,'',$classer_pard);



if ($veio!=1 and $veio!=3 )
{
    $vetTipoAgenda=Array();
    $vetTipoAgenda['Hora Extra']  = 'Extra';
    $vetTipoAgenda['Hora Marcada']= 'Hora Marcada';
    $classer_pard='a_centro';
    $vetCampo['origem'] = CriaVetTabela('Origem','descDominio',$vetTipoAgenda,'',$classer_pard,'',$classer_pard);
}


$vetCampo['gae_descricao'] = CriaVetTabela('Serviço Marcado');


if ($fixaconsultor==0)
{
     $vetCampo['pu_cliente_consultor'] = CriaVetTabela('Cliente <br />Consultor');
}
else
{
     //$vetCampo['ge_descricao'] = CriaVetTabela('Cliente');
	 
	 //$vetCampo['cliente_texto'] = CriaVetTabela('Cliente');
	 //$vetCampo['nome_empresa']  = CriaVetTabela('Empreendimento');
	 
	 $vetCampo['cliente_emp'] = CriaVetTabela('Cliente<br />Empreendimento');
	 
	 
}
if ($veio==10 or $veio==13 or  $veio==14)
{
   //$vetCampo['cnpj'] = CriaVetTabela('CNPJ');
   //$vetCampo['nome_empresa'] = CriaVetTabela('Empreendimento');
   $vetCampo['empresacnpj'] = CriaVetTabela('Empreendimento<br />CNPJ');
   
}


if ($veio!=10 and $veio!=11 and $veio!=13 and $veio!=14)
{   
    if ($fixaunidade==0)
    {   // Todos
       $vetCampo['especialidade_ponto'] = CriaVetTabela('Instrumento <br />Ponto Atendimento');
    }
    else
    {
        //$vetCampo['gae_descricao'] = CriaVetTabela('Especialidade');
       // $vetCampo['gae_descricao'] = CriaVetTabela('Instrumento');
	   // $vetCampo['servicos'] = CriaVetTabela('Serviços');
    }
}

//$vetCampo['ge_descricao'] = CriaVetTabela('Cliente');
//$vetCampo['pu_nome_completo'] = CriaVetTabela('Consultor');



//$vetCampo['telefone']         = CriaVetTabela('Telefone');

if ($veio!=10 and $veio!=11 and $veio!=13 and $veio!=14)
{
    $vetCampo['telefone_celular']         = CriaVetTabela('Telefone<br />Celular');
    
}
//$vetCampo['hora_confirmacao'] = CriaVetTabela('Hora<br />Conf.');

$vetCampo['confirmado'] = CriaVetTabela('Conf.?','descDominio',$vetSimNao);



if ($veio==10 or $veio==11 or $veio==13 or $veio==14)
{
    $vetCampo['hora_chegada']           = CriaVetTabela('Hora<br />Chegada');
    $vetCampo['hora_atendimento']       = CriaVetTabela('Hora<br />Inicial');
    $vetCampo['hora_final_atendimento'] = CriaVetTabela('Hora<br />Final');
}
else
{
    if ($veio!=1 and $veio!=3)
    {
        $vetCampo['hora_chegada'] = CriaVetTabela('Hora<br />Che.');
      //  $vetCampo['hora_liberacao'] = CriaVetTabela('Hora<br />Lib.');
        $vetCampo['hora_atendimento'] = CriaVetTabela('Hora<br />Aten.');
    }
}


$vetCampo['ga_protocolo'] = CriaVetTabela('Protocolo<br />Atendimento');
$vetCampo['ga_situacao'] = CriaVetTabela('Situação<br />Atendimento');

//$vetCampo['gae_descricao'] = CriaVetTabela('Especialidade');
//$vetCampo['sos_descricao'] = CriaVetTabela('Ponto Atendimento');
if ($vetFiltro['ponto_atendimento']['valor']!='' AND $vetFiltro['ponto_atendimento']['valor']!='-1')
{
    $fixaunidade=1;
}
//$vetCampo['origem'] = CriaVetTabela('Hora Marcada?','descDominio',$vetSimNao);


//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";

$sql  .= "   ga.protocolo as ga_protocolo,  ";
$sql  .= "   ga.situacao as ga_situacao,  ";

$sql  .= "   ge.descricao as ge_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo,  ";


$sql  .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";

//$sql  .= "  concat_ws('<br />', concat_ws('','-',ge.descricao) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
$sql  .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";

$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "   gae.descricao as gae_descricao,  ";

$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";


$sql  .= "  concat_ws('<br />', grc_aa.cliente_texto, grc_aa.nome_empresa) as cliente_emp,  ";


$sql  .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";




// alterado em 23/07/2015 - início

//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql  .= " inner join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
//$sql  .= " left join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
//$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";
//$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";

if ($veio==10) {
	$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
}

if ($vetFiltro['ponto_atendimento']['valor']!='' AND $vetFiltro['ponto_atendimento']['valor']!='-1')
{
$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = {$AliasPric}.idt_ponto_atendimento ";
}
else
{
$sql  .= " left join ".db_pir."sca_organizacao_secao as sos on sos.idt = {$AliasPric}.idt_ponto_atendimento ";
}

// alterado em 23/07/2015 - fim



$fezwere=0;



$dt_iniw   = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw   = trata_data($vetFiltro['dt_fim']['valor']);

//echo " veio = $veio ";

if ($veio==20 or $veio==1)
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
    $sql .= ' grc_aa.origem = '.aspa('Hora Marcada');

}


if ($vetFiltro['consgetadatas']['valor']=="S")
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
    $sql .= " grc_aa.data >= ".aspa($dt_iniw)." and grc_aa.data <=  ".aspa($dt_fimw)." " ;

	
	
	
}




//p($sql);
//exit();


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
    $sql .= ' grc_aa.idt_consultor= '.null($vetFiltro['idt_consultor']['valor']);

}



if ($vetFiltro['ponto_atendimento']['valor']!='' AND $vetFiltro['ponto_atendimento']['valor']!='-1')
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
    $sql .= ' grc_aa.idt_ponto_atendimento= '.null($vetFiltro['ponto_atendimento']['valor']);
  
}


if ($veio==10)
{  // chama proximo cliente ==== mostra os não chamados
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    }
    else
    {
        $sql .= ' and ';
    }
    $sql .= ' (grc_aa.hora_atendimento = '.aspa("")." or grc_aa.hora_atendimento is null )";
    $sql .= ' and (grc_aa.senha_totem is not null or grc_aa.senha_totem <> '.aspa('').') ';
    $sql .= ' and (substring(grc_aa.senha_totem,1,2) <> '.aspa('CH').') ';
    $sql .= ' and (pn.status_painel <> 33) ';
	
	


    
	
}

if ($veio==1477777)
{  // Pesquisar Cliente
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    }
    else 
    {
        $sql .= ' and ';
    }
    //$sql .= ' (hora_atendimento <> '.aspa("")." and hora_atendimento is not null )";
    $sql .= " ga.situacao = ".aspa("Finalizada");
}



//p($sql);




if ($veio==10 or $veio==11  or $veio==13 or $veio==14)
{  // salva para estatistica
    $sql_w=$sql;
}


if ($vetFiltro['idt_especialidade']['valor']!='' AND $vetFiltro['idt_especialidade']['valor']!='-1')
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
    $sql .= ' grc_aa.idt_especialidade= '.null($vetFiltro['idt_especialidade']['valor']);

}



if ($vetFiltro['idt_servico']['valor']!='' AND $vetFiltro['idt_servico']['valor']!='-1')
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
    $sql .= ' ( ';
    $sql .= "  {$AliasPric}.servicos_idt like ".aspa($vetFiltro['idt_servico']['valor'].'#', '%', '%');
    $sql .= ' ) ';

}








if ($vetFiltro['idt_instrumento']['valor']!='' AND $vetFiltro['idt_instrumento']['valor']!='-1')
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
    $sql .= ' grc_aa.idt_especialidade = '.null($vetFiltro['idt_instrumento']['valor']);
}



if ($vetFiltro['tipoagenda']['valor']!='T')
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
    $sql .= ' grc_aa.situacao= '.aspa($vetFiltro['tipoagenda']['valor']);

}



if ($vetFiltro['diasemana']['valor']!='Tod')
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
    $sql .= ' grc_aa.dia_semana = '.aspa($vetFiltro['diasemana']['valor']);

}

/*
if ($vetFiltro['tipofila']['valor']!="T")
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
    if ($vetFiltro['tipofila']['valor']=='HE')
    {
        $sql .= ' substring(grc_aa.senha_totem,1,2) = '.aspa('EX');
    }
    if ($vetFiltro['tipofila']['valor']=='HP')
    {
        $sql .= ' substring(grc_aa.senha_totem,1,2) = '.aspa('EP');
    }
    if ($vetFiltro['tipofila']['valor']=='HM')
    {
        $sql .= ' substring(grc_aa.senha_totem,1,1) = '.aspa('H');
    }
}
*/




if ($vetFiltro['protocolo']['valor']!="")
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
   // $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.protocolo)       like lower('.aspa($vetFiltro['protocolo']['valor'], '%', '%').')';
    $sql .= ' ) ';
}








if ($vetFiltro['texto']['valor']!="")
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
    // $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.data)            like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.dia_semana)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.hora)          like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.situacao)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.origem)        like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.protocolo)     like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.cliente_texto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.nome_empresa)  like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ge.descricao)                 like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo)             like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}






if ($vetFiltro['texto2']['valor']!="")
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
   // $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.data)       like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.dia_semana)     like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.protocolo)     like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.hora)     like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.situacao) like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.origem)   like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower(ge.descricao)            like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo)        like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';

    $sql .= ' ) ';
}



 if ($veio==5) // mostra apenas os marcados
 {   // imprimir comprovante
    if ($fezwere==0)
    {
        $sql .= ' where ';
        $fezwere=1;
    }
    else
    {
        $sql .= ' and ';
    }
    $sql .= ' grc_aa.situacao = '.aspa('MARCADO');

 
 }
 


	if ($veio==10)
	{   // fila de espera

		if ($vetFiltro['tipofila']['valor']!='T')
		{
			if ($vetFiltro['tipofila']['valor']=='HE')
			{
				$sql .= " and (substring(grc_aa.senha_totem,1,2) = 'EX') ";
			}
			if ($vetFiltro['tipofila']['valor']=='HP')
			{
				$sql .= " and (substring(grc_aa.senha_totem,1,2) = 'EP') ";
			}
			if ($vetFiltro['tipofila']['valor']=='HM')
			{
				$sql .= " and (substring(grc_aa.senha_totem,1,1) = 'H') ";
			}
		
		}
	}	
//$sql  .= " order by {$orderby}";

if ($veio!=10 and $veio!=11 and $veio!=14)
{   // imprimir comprovante
    if ($sqlOrderby == '')
    {
//            $sqlOrderby = "data asc, hora asc";
    }
}
else
{
    if ($sqlOrderby == '') {
//            $sqlOrderby = "senha_totem asc ";
    }
}
$refresh_painel = $vetConf['refresh_painel']*2000;
//p($vetConf);

//$refresh_painel = 10000;

?>




<script type="text/javascript">


    var desativarefresh=1;
    var refresh_painel         = '<?php echo $refresh_painel; ?>' ;
   // alert(' --------------- '+refresh_painel );

    var veio                   =  '<?php echo  $veio; ?>' ;
    var recepcao               =  '<?php echo  $recepcao; ?>' ;
    var balcao                 =  '<?php echo  $balcao; ?>' ;
    var callcenter             =  '<?php echo  $callcenter; ?>' ;

    var tembotaopasso          =  '<?php echo  $tembotaopasso; ?>' ;
    var idbotaopasso           =  '<?php echo  $idbotaopasso; ?>' ;


    var diasint = 90;
    // alert('balcao '+balcao);
    if (balcao==1)
    {
        //diasint = 1;
     		//$('#dt_ini').hide();
		    //$('#dt_fim').hide();

    }
   // alert('dias int '+diasint);
    $(document).ready(function () {
        $("#id_usuario2").cascade("#idt1", {ajax: {
            url: 'ajax_atendimento.php?tipo=usuario_especialidade&cas=' + conteudo_abrir_sistema
        }});
		//alert('veio '+veio);
        if (veio==20)
		{
		//alert('veio 5555 '+veio);
			$("#id_usuario1").cascade("#idt0", {ajax: {
					url: ajax_sistema + '?tipo=pesquisa_consultor_agenda&cas=' + conteudo_abrir_sistema
				}});
		}	


	$('#dt_ini, #dt_fim').change(function () {
	      valida_dt();
        });
        
    MarcaBotaoPasso();
    
    if (veio==10)
    {   // gestão de filas
        //var intervalo = window.setInterval(RefreshTime, refresh_painel);
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
function MarcaBotaoPasso()
{
    if (tembotaopasso=='S')
    {
        // Marcar Botão do Passo
        var cclassew = "";
        if (veio==10)
        {
            var classew = 'cell_ativado_272';
        }
        if (veio==11)
        {
            var classew = 'cell_ativado_306';
        }
        if (veio==13)
        {
            var classew = 'cell_ativado_308';
        }

        if (veio==14)
        {
            var classew = 'cell_ativado_310';
        }

        $('.'+classew).each(function () {
             $(this).css('border','1px solid #2A5696');
        });

        
        /*
        var id = idbotaopasso;
        objtp  = document.getElementById(id);
        if (objtp != null) {
            //alert('tem ai ');
           $(objtp).css('border','1px solid #2A5696');
           //$(objtp).css('padding','1px');
           //$(objtp).css('background','#2F66B8');
            //alert('tem fez ');
        }
        */

    }
}
function RefreshTime()
{
   if (desativarefresh==1)
   {
       location.reload();
   }
}

function Chamar_Proximo()
{
    alert('criar funcionalidade de chamar próximo');

}
</script>
