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

$bt_print          = false;

//listar_rel_exportar('')



$barra_inc_ap = true;
$barra_alt_ap = true;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;

//$barra_inc_img = "imagens/agenda_nova.png";
//$barra_alt_img = "imagens/agenda_alterar.png";
//$barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Incluir um Novo Agendamento';
$barra_alt_h = 'Alterar o Agendamento';
$barra_con_h = 'Consultar o Agendamento';

// p($_GET);
// p($_SESSION[CS]);

 $veio = $_GET['veio'];

echo "<div class='cab_1' >";
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





 // Gestão de Filas
 if ($veio==10)
 {  // chama proximo cliente
  $tituloveio = "  CHAMAR PRÓXIMO CLIENTE ";

  $prefixow='inc';
  $mostrar    = true;
  $cond_campo = '';
  $cond_valor = '';
  //$veio = "D";
  $direito_geral=1;
  
  
  $imagem  = 'imagens/remover.png';
  $goCad[] = vetCad('idt', 'Cancelar a Senha de Atendimento', 'grc_remove_senha_fila', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

  
  $imagem  = 'imagens/chamar_cliente.png';
  $goCad[] = vetCad('idt', 'Chamar Cliente para Atendimento', 'grc_chama_cliente_fila', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
  
  

  
 }
 if ($veio==11)
 {  // chama proximo cliente
    $tituloveio = "  VISUALIZAR PARA IMPRESSÃO ";
 }
 if ($veio==14)
 {  // chama proximo cliente
    $tituloveio = "  PESQUISAR CLIENTE ";
 }


 if ($veio==10 or $veio==11 or $veio==14)
 {  // chama proximo cliente
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
 $delayinicial = '+45 day';
 
 if ($veio==1)
 {   // Minha Agenda
     $tipo_agenda   = $veio;
     $comfiltro     = 'F';
     $fixaunidade   = 1;
     $fixaconsultor = 1;
     $delayinicial = '+0 day';
     $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
     $idt_consultor         = $_SESSION[CS]['g_id_usuario'];
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

 if ($veio==14)
 {  // PESQUISAR CLIENTE
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


 
 
 //echo " -------------    $idt_ponto_atendimento ";
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


if ($fixaconsultor==0)
{

    // aqui deve ser todos os usuários das unidades
    
    $sql  = "select distinct plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
    $sql .= " inner join grc_atendimento_usuario_especialidade grc_aue on grc_aue.idt_usuario = plu_usu.id_usuario ";
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
if ($fixaconsultor==0)
{
    $Filtro['LinhaUm']   = '-- Selecione o Consultor --';
}
else
{
    //$Filtro['LinhaUm']   = $idt_consultor;
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
$vetTipoAgenda['T']='Agendado/Marcado';
$vetTipoAgenda['Agendado']='Agendado';
$vetTipoAgenda['Marcado']='Marcado';

$Filtro = Array();
$Filtro['rs']        = $vetTipoAgenda;
$Filtro['id']        = 'tipoagenda';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Marcados/Agendados';
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




if ($veio==10 or $veio==11 or $veio==14)
{
   $classer_pard='a_centro';
   //$vetCampo['protocolo'] = CriaVetTabela('Senha','','','',$classer_pard,'',$classer_pard);
   $vetCampo['senha_totem'] = CriaVetTabela('Senha','','','',$classer_pard,'',$classer_pard);
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
$vetTipoAgenda=Array();
$vetTipoAgenda['Agendado']   ='AGENDADO';
$vetTipoAgenda['Marcado']    ='MARCADO';
$vetTipoAgenda['Cancelado']  ='CANCELADO';
$classer_pard='a_centro';
$vetCampo['situacao'] = CriaVetTabela('Status','descDominio',$vetTipoAgenda,'',$classer_pard,'',$classer_pard);

if ($veio!=1 and $veio!=3 )
{
    $vetTipoAgenda=Array();
    $vetTipoAgenda['Hora Extra']='Extra';
    $vetTipoAgenda['Hora Marcada']='Marcada';
    $classer_pard='a_centro';
    $vetCampo['origem'] = CriaVetTabela('Origem','descDominio',$vetTipoAgenda,'',$classer_pard,'',$classer_pard);
}



if ($fixaconsultor==0)
{
     $vetCampo['pu_cliente_consultor'] = CriaVetTabela('Cliente <br />Consultor');
}
else
{
     $vetCampo['ge_descricao'] = CriaVetTabela('Cliente');
}
if ($veio==10 or $veio==14)
{
   //$vetCampo['cnpj'] = CriaVetTabela('CNPJ');
   //$vetCampo['nome_empresa'] = CriaVetTabela('Empreendimento');
   $vetCampo['empresacnpj'] = CriaVetTabela('Empreendimento<br />CNPJ');
   
}


if ($veio!=10 and $veio!=11 and $veio!=14)
{   // imprimir comprovante
    if ($fixaunidade==0)
    {   // Todos
       $vetCampo['especialidade_ponto'] = CriaVetTabela('Instrumento <br />Ponto Atendimento');
    }
    else
    {
        //$vetCampo['gae_descricao'] = CriaVetTabela('Especialidade');
        $vetCampo['gae_descricao'] = CriaVetTabela('Instrumento');
    }
}

//$vetCampo['ge_descricao'] = CriaVetTabela('Cliente');
//$vetCampo['pu_nome_completo'] = CriaVetTabela('Consultor');



//$vetCampo['telefone']         = CriaVetTabela('Telefone');

if ($veio!=10 and $veio!=11 and $veio!=14)
{
    $vetCampo['telefone_celular']         = CriaVetTabela('Telefone<br />Celular');
    
}
$vetCampo['hora_confirmacao'] = CriaVetTabela('Hora<br />Conf.');


if ($veio==10 or $veio==11 or $veio==14)
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
        $vetCampo['hora_liberacao'] = CriaVetTabela('Hora<br />Lib.');
        $vetCampo['hora_atendimento'] = CriaVetTabela('Hora<br />Aten.');
    }
}
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
$sql  .= "   ge.descricao as ge_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo,  ";


$sql  .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";

//$sql  .= "  concat_ws('<br />', concat_ws('','-',ge.descricao) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
$sql  .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";

$sql  .= "   sos.descricao as sos_descricao,  ";

$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";


$sql  .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";




// alterado em 23/07/2015 - início

//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql  .= " inner join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
//$sql  .= " left join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
//$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";
//$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";

$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = .{$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = .{$AliasPric}.idt_cliente ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_consultor ";

if ($vetFiltro['ponto_atendimento']['valor']!='' AND $vetFiltro['ponto_atendimento']['valor']!='-1')
{
$sql  .= " inner join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";
}
else
{
$sql  .= " left join ".db_pir."sca_organizacao_secao as sos on sos.idt = .{$AliasPric}.idt_ponto_atendimento ";
}

// alterado em 23/07/2015 - fim



$fezwere=0;

$dt_iniw   = trata_data($vetFiltro['dt_ini']['valor']);
$dt_fimw   = trata_data($vetFiltro['dt_fim']['valor']);

if ($vetFiltro['consgetadatas']['valor']=="S")
{
    $sql .= ' where ';
    $sql .= " data >= ".aspa($dt_iniw)." and data <=  ".aspa($dt_fimw)." " ;
    $fezwere=1;
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
    $sql .= ' hora_atendimento = '.aspa("");

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
    $sql .= ' situacao= '.aspa($vetFiltro['tipoagenda']['valor']);

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
    $sql .= ' idt_especialidade= '.null($vetFiltro['idt_especialidade']['valor']);

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
    $sql .= ' idt_ponto_atendimento= '.null($vetFiltro['ponto_atendimento']['valor']);
  
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
    $sql .= '  lower('.$AliasPric.'.data)       like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.dia_semana)     like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

    $sql .= ' or lower('.$AliasPric.'.hora)     like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.situacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.origem)   like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(ge.descricao)            like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo)        like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

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

    $sql .= ' or lower('.$AliasPric.'.hora)     like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.situacao) like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.origem)   like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower(ge.descricao)            like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';
    $sql .= ' or lower(pu.nome_completo)        like lower('.aspa($vetFiltro['texto2']['valor'], '%', '%').')';

    $sql .= ' ) ';
}



 if ($veio==5)
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
    $sql .= ' situacao = '.aspa('MARCADO');

 
 }

//$sql  .= " order by {$orderby}";

if ($veio!=10 and $veio!=11 and $veio!=14)
{   // imprimir comprovante
    if ($sqlOrderby == '')
    {
            $sqlOrderby = "data asc, hora asc";
    }
}
else
{
    if ($sqlOrderby == '') {
            $sqlOrderby = "protocolo asc, data asc, hora asc";
    }
}

?>
<script type="text/javascript">

    var recepcao               =  '<?php echo  $recepcao; ?>' ;
    var balcao                 =  '<?php echo  $balcao; ?>' ;
    var callcenter             =  '<?php echo  $callcenter; ?>' ;

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
            url: 'ajax_atendimento.php?tipo=usuario_especialidade&cas=' + conteudo_abrir_sistema,
        }});
        


	$('#dt_ini, #dt_fim').change(function () {
	      valida_dt();
        });
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
