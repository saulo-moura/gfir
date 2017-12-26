<style>
    #idt_unidade_regional {
        width:250px;

    }
    #idt_ponto_atendimento {
        width:250px;

    }
    #idt_projeto {
        width:350px;

    }
    #idt_acao {
        width:250px;

    }
    #idt_agente {
        width:250px;

    }
    #idt_tutor {
        width:250px;

    }

    #idt_empresa_executora {
        width:250px;

    }

    #idt_porte {
        width:250px;

    }
    #idt_motivo_desistencia {
        width:250px;

    }
    #idt_ferramenta {
        width:250px;

    }
    #idt_status {
        width:250px;

    }
	#filtro {
        width:50%;

    }
	#classificacao {
        width:100%;

    }

</style>
<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Atendimento";

$listar_sql_limit = false;

$TabelaPrinc = "grc_atendimento";
$AliasPric   = "grc_atd";
$Entidade    = "Atendimento";
$Entidade_p  = "Atendimentos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$_SESSION[CS]['grc_atendimento_listar'] = $_SERVER['REQUEST_URI'];

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;


$vetBtBarraListarRel = Array(
    'print' => false,
    'pdf' => true,
    'xls' => true,
    'fechar' => true,
);

$_SESSION[CS]['g_titulo_rel']="Atendimentos - Analítico";
$_SESSION[CS]['g_direcao_impressao']="L";
$_SESSION[CS]['g_lado_direito_cab']="N";
$_SESSION[CS]['g_rodape']="S";



$outramsgvazio = false;
$vetBtBarraListarRel['fechar'] = false;



function func_trata_row_grc_atendimento($row) {
    global $barra_alt_ap;

    if ($row['situacao'] == 'Finalizado') {
        $barra_alt_ap = false;
    } else {
        $barra_alt_ap = true;
    }
}

$func_trata_row = func_trata_row_grc_atendimento;

$barra_inc_img = "imagens/incluir_novo_atendimento.png";
//$barra_alt_img = "imagens/agenda_alterar.png";
//$barra_con_img = "imagens/agenda_consultar.png";

$barra_inc_h = 'Clique aqui para Incluir um Novo Atendimento Presencial';
$barra_alt_h = 'Alterar o Atendimento Presencial';
$barra_con_h = 'Consultar o Atendimento Presencial';

$tipoidentificacao = 'N';
$tipofiltro        = 'S';
$comfiltro         = 'A';
$comidentificacao  = 'F';


$prefixow = 'inc';
$mostrar = true;
$cond_campo = '';
$cond_valor = '';
//$veio = "D";
$direito_geral = 1;

/*
  $veiodoatendimento = 'S';
  $_GET['veiodoatendimento']=$veiodoatendimento;
  $_SESSION[CS]['veiodoatendimento'] = $veiodoatendimento;
  $imagem  = 'imagens/cadastro_clientes.png';
  $goCad[] = vetCad('idt', 'Cadastro de Clientes', 'grc_chama_cadastro_cliente', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
 */

/*
  $tipoidentificacao = 'N';
  $tipofiltro        = 'N';
  $comfiltro         = 'F';
  $comidentificacao  = 'F';
 */



//$bt_print = false;
//$_GET['instrumento']=1;

echo "<div class='cab_1' >";
$recepcao = $_GET['recepcao'];

//$recepcao = '';
//echo "ATENDIMENTO DE Presencial";

$_SESSION[CS]['fu_recepcao'] = $recepcao;
if ($recepcao == 1) {
    echo "  ATENDIMENTO DE RECEPÇÃO";
}

$balcao = $_GET['balcao'];
if ($_SESSION[CS]['fu_balcao'] == "") {
    $_SESSION[CS]['fu_balcao'] = $balcao;
} else {
    $balcao = $_SESSION[CS]['fu_balcao'];
}
if ($balcao == 1) {
    echo "  ATENDIMENTO DE BALCAO";
}
$callcenter = $_GET['callcenter'];
$_SESSION[CS]['fu_callcenter'] = $callcenter;
if ($callcenter == 1) {
    echo "  ATENDIMENTO EM CALL CENTER";
}
echo "</div>";


// p($_POST);
//
// Descida para o nivel 2
//
$prefixow   = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';

/*
  $imagem  = 'imagens/empresa_16.png';
  $goCad[] = vetCad('idt', 'Diagnóstico', 'grc_atendimento_diagnostico', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);

  $imagem  = 'imagens/empresa_16.png';
  $goCad[] = vetCad('idt', 'Produtos', 'grc_atendimento_produto', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);
 */

$idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
$idt_usuario = $_SESSION[CS]['g_id_usuario'];

$Filtro = Array();
$Filtro['rs']    = 'Hidden';
$Filtro['id']    = 'idt_pesquisa_sel';
$Filtro['valor'] = '';
$vetFiltro['idt_pesquisa_sel'] = $Filtro;
//p($_GET);
//p($_POST);


//p($vetFiltro['idt_pesquisa_sel']['valor']);

if ($_POST['idt_pesquisa_sel']!="")
{
	
	$sql  = '';
	$sql .= ' select plu_p.*';
	$sql .= ' from plu_pesquisa plu_p';
	$sql .= ' where idt = '.null($_POST['idt_pesquisa_sel']);
	$rs   = execsql($sql);
	$codigo    = "";
	foreach ($rs->data as $row) {
		$codigo    = $row['codigo'];
		$descricao = $row['descricao'];
		$post_slv  = $row['post_slv'];
		$get_slv  = $row['get_slv'];
	}
	if ($codigo!= "")
	{
		//$post_slv   = str_replace('#','"',$post_slv);
		$_POST      = unserialize(base64_decode($post_slv));
		//$get_slv    = str_replace('#','"',$get_slv);
		$_GET       = unserialize(base64_decode($get_slv));
		$_REQUEST   = array_merge($_POST,$_GET);
	}
}











$Filtro = Array();
$Filtro['rs'] = $vetSimNao;
$Filtro['id'] = 'filtro_erro';
$Filtro['nome'] = 'Integração com Erro';
$Filtro['valor'] = trata_id($Filtro);
// $vetFiltro['erro'] = $Filtro;
// echo " -------------    $idt_ponto_atendimento ";
// Unidade Regional
$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento <> 'S'  ";
$sql .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_unidade_regional';
$Filtro['js_tam']  = '0';
$Filtro['LinhaUm'] = '-- Selecione Unidade Regional --';
$Filtro['nome']    = 'Unidade Regional';
$Filtro['valor']   = trata_id($Filtro);
$vetFiltro['idt_unidade_regional'] = $Filtro;

// Ponto de Atendimento

$fixaunidade = 0;
if ($fixaunidade == 0) {   // Todos
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql .= " where posto_atendimento = 'S' ";
    $sql .= ' order by classificacao ';
} else {
    $sql = 'select ';
    $sql .= '   idt, descricao  ';
    $sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
    if ($_SESSION[CS]['g_atendimento_relacao'] == 'G') {
        $sql .= ' and SUBSTRING(classificacao, 1, 5) = ('; //and
        $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql .= ' from '.db_pir.'sca_organizacao_secao';
        $sql .= ' where idt = '.null($idt_ponto_atendimento);
        $sql .= ' )';
    } else {
        $sql .= "   and idt = ".null($idt_ponto_atendimento);
    }
    $sql .= ' order by classificacao ';
}
$rs = execsql($sql);



$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt_ponto_atendimento';
$Filtro['id_select'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['LinhaUm']   = '-- Selecione o PA --';
$Filtro['nome'] = 'Ponto de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ponto_atendimento'] = $Filtro;
//
// Projeto
//
$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_projeto';
$Filtro['nome'] = 'Projeto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_projeto'] = $Filtro;
//
// Ação
//
$Filtro = Array();
$Filtro['rs'] = 'ListarCmb';
$Filtro['arq'] = 'grc_projeto_acao';
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_acao';
$Filtro['nome'] = 'Acao';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_projeto_acao'] = $Filtro;


/*
//
// Empresas Executoras
//
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir_gec.'gec_entidade gec_e ';
$sql .= " where credenciado_nan = 'S'";
$sql .= " and credenciado = 'S'";
$sql .= " and nan_ano = ".aspa(nan_ano);
$sql .= ' order by descricao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_empresa_executora';
$Filtro['nome'] = 'Empresa Executora:';
$Filtro['LinhaUm'] = '-- Selecione Empresa Executora -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_empresa_executora'] = $Filtro;

// Tutor - Gestor

$sql = '';
$sql .= ' select id_usuario, nome_completo';
$sql .= ' from plu_usuario';
//$sql .= " where ativo = 'S'";
$sql .= ' order by nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'idt_tutor';
$Filtro['nome'] = 'Tutor/Gestor:';
$Filtro['LinhaUm'] = ' -- Selecione Tutor/Gestor --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_tutor'] = $Filtro;

// Agente

$sql = '';
$sql .= ' select id_usuario, nome_completo';
$sql .= ' from plu_usuario';
//$sql .= " where ativo = 'S'";
$sql .= ' order by nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'idt_agente';
$Filtro['nome'] = 'Agente:';
$Filtro['LinhaUm'] = '-- Selecione Agente -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_agente'] = $Filtro;

//
// Número da Visita
//
$vetVisitas = Array();
$vetVisitas[1] = 'Visita 1';
$vetVisitas[2] = 'Visita 2';
$Filtro = Array();
$Filtro['rs'] = $vetVisitas;
$Filtro['id'] = 'numero_visitas';
$Filtro['nome'] = 'Número da Visita:';
$Filtro['LinhaUm'] = '-- Selecione Visita --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['numero_visitas'] = $Filtro;

*/


//
// Porte da empresa
//
$sql = '';
$sql .= ' select idt, descricao, desc_vl_cmb';
$sql .= ' from '.db_pir_gec.'gec_organizacao_porte';
$sql .= " where codigo in ('2', '3', '99')";
$sql .= ' order by descricao, desc_vl_cmb';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';

$Filtro['id'] = 'idt_porte';
$Filtro['nome'] = 'Porte/Faixa de Faturamento';
$Filtro['LinhaUm'] = ' Selecione Porte da Empresa --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_porte'] = $Filtro;



/*
// Motivo da Desistência

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_nan_motivo_desistencia';
//$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';

$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt_motivo_desistencia';
$Filtro['id_select'] = 'idt';

$Filtro['nome'] = 'Motivo da Desistência:';
$Filtro['LinhaUm'] = '-- Selecione Motivo da Desistência --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_motivo_desistencia'] = $Filtro;


//
// Ferramentas
//
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_formulario_ferramenta_gestao';
//$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';

$Filtro['id'] = 'idt_ferramenta';
$Filtro['nome'] = 'Ferramentas:';
$Filtro['LinhaUm'] = '-- Selecione a Ferramenta -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_ferramenta'] = $Filtro;
//
// Perspectiva Empresarial
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto_perspectiva_empresarial';
$Filtro['nome'] = 'Perspectiva Empresarial:';
$Filtro['LinhaUm'] = ' -- Selecione Perspectiva Empresarial --';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['perspectiva_empresarial'] = $Filtro;
*/


/*
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_ini';
$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('-45 day'));

//$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Inicial:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_ini'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_dt_fim';
//$Filtro['vlPadrao']  = Date('d/m/Y', strtotime('+45 day'));
$Filtro['vlPadrao'] = Date('d/m/Y');
$Filtro['js'] = 'data';
$Filtro['nome'] = 'Data Final:';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['dt_fim'] = $Filtro;
*/


$Filtro = Array();
$Filtro['rs'] = 'Intervalo';
$Filtro['id'] = 'atendimento';
$Filtro['nome'] = 'Período do Atendimento';
$Filtro['js'] = 'data';
$Filtro['vlPadrao_ini'] = Date('d/m/Y', strtotime('-45 day'));
$Filtro['vlPadrao_fim'] = Date('d/m/Y');
$Filtro['valor_ini'] = trata_id($Filtro, '_ini');
$Filtro['valor_fim'] = trata_id($Filtro, '_fim');
$vetFiltro['atendimento'] = $Filtro;





//
// status
//
$vetSituacaoAtendimento=Array();
$vetSituacaoAtendimento['Todos']='-- Todos --';
$vetSituacaoAtendimento['Esperando Atendimento']='Esperando Atendimento';
$vetSituacaoAtendimento['Finalizado']='Finalizado';
$vetSituacaoAtendimento['Cancelado']='Cancelado';
$vetSituacaoAtendimento['Finalizado em Alteração']='Finalizado em Alteração';
$vetSituacaoAtendimento['Enviar para Validação']='Enviar para Validação';

//$sql = '';
//$sql .= ' select distinct situacao, situacao';
//$sql .= ' from grc_atendimento';
$Filtro = Array();
$Filtro['rs'] = $vetSituacaoAtendimento;
$Filtro['id_select'] = 'idt';
$Filtro['id']        = 'status';
$Filtro['nome']      = 'Status';
//$Filtro['LinhaUm']   = ' -- Todos -- ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['status'] = $Filtro;




//
// tipo
//
$vetTipoDeAtendimento=Array();
$vetTipoDeAtendimento['Todos']  = '-- Todos --';
$vetTipoDeAtendimento['Balcao']    = 'Balcao - Presencial';
$vetTipoDeAtendimento['Distancia'] = 'Distância';

$vetTipoDeAtendimento['NAN']    = 'NAN';
$vetTipoDeAtendimento['Evento'] = 'Evento';
//
$Filtro = Array();
$Filtro['rs'] = $vetTipoDeAtendimento;
$Filtro['id_select'] = 'idt';
$Filtro['id']        = 'tipoatendimento';
$Filtro['nome']      = 'Tipo de Atendimento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['tipoatendimento'] = $Filtro;

//
// Texto Livre
//
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Hidden';
$Filtro['id'] = 'pesquisa';
$Filtro['valor'] = 'S';
$vetFiltro['pesquisa'] = $Filtro;


$TabelaPrinc = "grc_atendimento";
$AliasPric = "grc_atd";
$Entidade = "Atendimento";
$Entidade_p = "Atendimentos";
//
$idt_instrumento = 13;
//
// Campos variáveis da lista
//
$vetTabelas = Array();
$vetTabelas = NAN_MontaListas($menu);
if (count($vetTabelas) == 0) {
    $padrao = 1;
} else {
    $padrao = 0;
}
$vetCampo = Array();
$qtdcamposescolhidos = 0;
//p($_POST);
$vetCpoP = $vetTabelas['CTP'];
$ordem = 0;
$vetCampoOrdem = Array();
ForEach ($vetCpoP as $GrupoP => $vetQualificadoresG) {
    ForEach ($vetQualificadoresG as $CampoPesq => $vetQualificadores) {
        $campo_caption = $vetQualificadores['dsc'];
        $campo_tipo = $vetQualificadores['tip'];
        $campo_tam = $vetQualificadores['tam'];
		$campo_vet = $vetQualificadores['vet'];

        $colativa = "{$GrupoP}_{$CampoPesq}";

        if ($_POST[$colativa] != "") {
            $ordem = $ordem + 1;
            $colativaordem = "{$GrupoP}_{$CampoPesq}_t";
			$ordpost = $_POST[$colativaordem];
			if ($ordpost=='')
			{
			    $ordpost=99999;
			}
			
            $a = '1'.ZeroEsq($ordpost, 5);
            $colativaordem = $a.ZeroEsq($ordem,5).$CampoPesq;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['dsc'] = $campo_caption;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tip'] = $campo_tipo;
            $vetCampoOrdem[$colativaordem][$CampoPesq]['tam'] = $campo_tam;
			$vetCampoOrdem[$colativaordem][$CampoPesq]['vet'] = $campo_vet;

            //$vetCampo[$CampoPesq] = CriaVetTabela($campo_caption,$campo_tipo); 
            $qtdcamposescolhidos = $qtdcamposescolhidos + 1;
        }
    }
}
ksort($vetCampoOrdem);
//p($vetCampoOrdem);

$largura = 0;


if ($qtdcamposescolhidos > 0) {
    $vetOrderby=Array();
}

// p($_POST['sql_orderby']);
$vetOrdenacaoColunas=$_POST['sql_orderby'];
if (is_array($vetOrdenacaoColunas))
{
    $vetO=Array(); 
	$ord = 0;
	ForEach ($vetOrdenacaoColunas as $num => $cpo) {
	   $ord = $ord + 1; 
	   $vetO[$cpo]=$ord;
	}
  //  p($vetO);
	
    $vetCampoOrdemw=Array();
	ForEach ($vetCampoOrdem as $colativaordem => $vetCamposemOrdem) {
	    ForEach ($vetCamposemOrdem as $CampoPesq => $vetQualificadores) {
           $ord=$vetO[$CampoPesq];
		   $vetCampoOrdemw[$ord]=$vetCamposemOrdem; 
		   
		}   
	}
//	ksort($vetCampoOrdemw);
	
	$vetCampoOrdemw=$vetCampoOrdem;
	
//	p($vetCampoOrdemw);
}
else
{
    $vetCampoOrdemw=$vetCampoOrdem;
}
ForEach ($vetCampoOrdemw as $colativaordem => $vetCamposemOrdem) {
    ForEach ($vetCamposemOrdem as $CampoPesq => $vetQualificadores) {
        $campo_caption = $vetQualificadores['dsc'];
        $campo_tipo    = $vetQualificadores['tip'];
		$campo_vet     = $vetQualificadores['vet'];
		if ($campo_vet=='')
		{
            $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo);
		}
		else
		{
		    $vetCampo[$CampoPesq] = CriaVetTabela($campo_caption, $campo_tipo, $$campo_vet);
		}
        $campo_tam = $vetQualificadores['tam'];
		
		$vetOrderby[$CampoPesq] = $campo_caption;
		
        if ($campo_tam == "") {
            $campo_tam = 250;
        }
        $largura = $largura + $campo_tam;
    }
}
if ($qtdcamposescolhidos > 0) {
    // criar style
    if ($largura > 1000) {
        echo '<style>';
        echo 'div#geral { ';
        echo "   width:{$largura}px; ";
        echo '} ';
        echo '</style> ';
    }
	else
	{
	    $largura=1100;
	    echo '<style>';
        echo 'div#geral { ';
        echo "   width:{$largura}px; ";
        echo '} ';
        echo '</style> ';
	
	}
}
else
{
	    $largura=1100;
	    echo '<style>';
        echo 'div#geral { ';
        echo "   width:{$largura}px; ";
        echo '} ';
        echo '</style> ';


}

//////////////
if ($padrao == 1 or $qtdcamposescolhidos == 0) {
    $vetCampo = Array();
    if ($vetFiltro['idt_consultor']['valor'] != '' AND $vetFiltro['idt_consultor']['valor'] != '-1') {
        // o consultor esta fixado.
    } else {
       // $vetCampo['at_agente'] = CriaVetTabela('Agente');
    }
    $vetCampo['at_protocolo']                = CriaVetTabela('Protocolo');
    $vetCampo['pf_cpf']                      = CriaVetTabela('CPF<br />Representante');
    $vetCampo['at_representante']            = CriaVetTabela('Nome Representante');
    $vetCampo['at_data']                     = CriaVetTabela('Data', 'data');
    $vetCampo['at_hora_inicio_atendimento']  = CriaVetTabela('Hora<br />Inicial');
    $vetCampo['at_hora_termino_atendimento'] = CriaVetTabela('Hora<br />Final');
	$vetCampo['at_horas_atendimento']        = CriaVetTabela('Duração');
	// $vetCampo['at_horas_atendimento']        = CriaVetTabela('Duração');
    // $vetCampo['grc_nga_status']            = CriaVetTabela('Situação','descDominio',$vetNanGrupo);
    // $vetCampo['at_instrumento']              = CriaVetTabela('Visita');
}

function ftd_siac($valor, $row, $Campo) {
    $html = '';
    $style = 'style="cursor: help;"';
    if ($valor != '') {
        if ($row[$Campo.'_erro'] == '') {
            $html .= '<img src="imagens/icone_ok.gif" title="'.$valor.'" '.$style.' />';
        } else {
            $html .= '<img src="imagens/valor_alterado.png" title="'.$valor.' - '.$row[$Campo.'_erro'].'" '.$style.' />';
        }
    }
    return $html;
}

//p($vetCampo);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "   {$AliasPric}.protocolo                  as at_protocolo,  ";
$sql .= "   {$AliasPric}.data                       as at_data,  ";
$sql .= "   {$AliasPric}.hora_inicio_atendimento    as at_hora_inicio_atendimento,  ";
$sql .= "   {$AliasPric}.hora_termino_atendimento   as at_hora_termino_atendimento,  ";
$sql .= "   {$AliasPric}.horas_atendimento          as at_horas_atendimento,  ";
$sql .= "   {$AliasPric}.nan_num_visita                 as at_ciclo,  ";
//$sql .= "   {$AliasPric}.nan_ap_dt_at               as at_data_registro,  ";
$sql .= "   {$AliasPric}.nan_motivo_desistencia     as at_motivo_desistencia,  ";
$sql .= "   {$AliasPric}.nan_prazo_validacao        as at_prazo_validacao,  ";
$sql .= "   {$AliasPric}.data       as at_data_registro,  ";

$sql .= "   grc_ai.descricao                        as at_instrumento,  ";
$sql .= "   plu_usuc.nome_completo                  as at_agente,  ";
$sql .= "   plu_usue.nome_completo                  as at_empresa_executora,  ";
$sql .= "   plu_usut.nome_completo                  as at_tutor,  ";
$sql .= "   sca_s.descricao                         as at_ponto_atendimento,  ";
$sql .= "   sca_u.descricao                         as at_nome_unidade,  ";
//$sql .= "   grc_nga.status                          as at_situacao,  ";

$sql .= "   {$AliasPric}.situacao                   as at_situacao,  ";

$sql .= "   grc_p.descricao                         as at_projeto,  ";
$sql .= "   grc_pa.descricao                        as at_acao,  ";

// $sql .= "   grc_nga.status                          as grc_nga_status,  ";


$sql .= "   ao.cnpj             as pj_cnpj,  ";
$sql .= "   ao.cnpj             as at_cnpj,  ";
$sql .= "   ao.razao_social     as pj_razao_social,  ";
$sql .= "   ao.razao_social     as at_cliente,  ";
$sql .= "   ao.nome_fantasia    as pj_nome_fantasia,  ";

$sql .= "   ao.data_abertura    as pj_data_abertura,  ";
$sql .= "   ao.pessoas_ocupadas as pj_pessoas_ocupadas,  ";
$sql .= "   ao.simples_nacional as pj_optante_simples,  ";



$sql .= "   ao.logradouro_cep_e         as pj_cep,  ";
$sql .= "   ao.logradouro_endereco_e    as pj_logradouro,  ";
$sql .= "   ao.logradouro_numero_e      as pj_numero,  ";
$sql .= "   ao.logradouro_complemento_e as pj_complemento,  ";
$sql .= "   ao.logradouro_bairro_e      as pj_bairro,  ";
$sql .= "   ao.logradouro_cidade_e      as pj_cidade,  ";
$sql .= "   ao.logradouro_estado_e      as pj_estado,  ";
$sql .= "   ao.logradouro_pais_e        as pj_pais,  ";

$sql .= "   ao.telefone_comercial_e     as pj_telefone_principal,  ";
$sql .= "   ao.telefone_celular_e       as pj_telefone_secundario,  ";

$sql .= "   ao.email_e                  as pj_email,  ";
$sql .= "   ao.site_url                 as pj_site_url,  ";

$sql .= "   op.desc_vl_cmb   as pj_porte_faixa,  ";
$sql .= "   car.desccargcli  as pj_cargo_representante,  ";
$sql .= "   cn.descricao     as pj_atividade_economica,  ";
$sql .= "   st.descricao     as pj_setor,  ";

$sql .= "   ete.descricao    as pj_tipo_empreendimento,  ";




$sql .= "   ap.cpf             as pf_cpf,  "; 
$sql .= "   ap.nome            as pf_nome,  ";
$sql .= "   ap.data_nascimento as pf_data_nascimento,  ";

$sql .= "   ap.logradouro_cep as pf_cep,  ";
$sql .= "   ap.logradouro_endereco as pf_logradouro,  ";
$sql .= "   ap.logradouro_numero as pf_numero,  ";
$sql .= "   ap.logradouro_complemento as pf_complemento,  ";
$sql .= "   ap.logradouro_bairro as pf_bairro,  ";
$sql .= "   ap.logradouro_cidade as pf_cidade,  ";
$sql .= "   ap.logradouro_estado as pf_estado,  ";
$sql .= "   ap.logradouro_pais as pf_pais,  ";


$sql .= "   ap.telefone_residencial as pf_telefone_residencial,  ";
$sql .= "   ap.telefone_recado      as pf_telefone_recado,  ";
$sql .= "   ap.telefone_celular     as pf_telefone_celular,  ";
$sql .= "   ap.email                as pf_email,  ";
$sql .= "   ap.necessidade_especial as pf_necessidade_especial,  ";
$sql .= "   ap.potencial_personagem as pf_potencial_personagem,  ";

$sql .= "   gec_es.descricao as pf_escolaridade,  ";
$sql .= "   gec_s.descricao  as pf_sexo,  ";

$sql .= "   ap.nome          as at_representante,  ";

$sql .= "  plu_usuc.nome_completo as nome_consultor,";
$sql .= " concat_ws('<br />', ap.cpf, ap.nome) as ap_cpf,";
$sql .= " concat_ws('<br />', ao.cnpj, concat_ws(' - ', op.descricao, op.desc_vl_cmb)) as cnpj_porte,";
$sql .= "    plu_usuc.nome_completo as plu_usuc_nome_completo, ";
$sql .= "    plu_usud.nome_completo as plu_usud_nome_completo, ";


$sql .= "    ao.razao_social as grc_ent_descricao,  ";
$sql .= "    grc_ai.descricao as grc_ai_descricao,  ";

// Evento
$sql .= "    grc_ev.codigo    as grc_ev_codigo,  ";
$sql .= "    grc_ev.descricao as grc_ev_descricao,  ";

$sql .= "    grc_ev.dt_previsao_inicial as grc_ev_dt_previsao_inicial,  ";
$sql .= "    grc_ev.hora_inicio as grc_ev_hora_inicio,  ";


$sql .= "    grc_prod.descricao as grc_prod_descricao,  ";



$sql .= "    grc_evs.descricao as grc_evs_descricao,  ";
$sql .= "    grc_proj.descricao as grc_proj_descricao,  ";
$sql .= "    grc_proj.gestor as grc_proj_gestor,  ";
$sql .= "    grc_projs.descricao as grc_projs_fase,  ";
$sql .= "    grc_proja.descricao as grc_proja_descricao,  ";

$sql .= "    sca_eve_u.descricao as sca_eve_u_unidade,  ";
$sql .= "    sca_eve_pa.descricao as sca_eve_pa_ponto_atendimento,  ";
$sql .= "    plu_usuge.nome_completo as plu_usuge_gestor_evento, ";

$sql .= "    cid.desccid as cidade,";
$sql .= "    loc.descricao as sala,";



// Participantes
$sql .= "    grc_evp.ativo as grc_evp_ativo,  ";
$sql .= "    grc_evp.contrato as grc_evp_contrato  ";





$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
//$sql .= " inner  join grc_nan_grupo_atendimento  grc_nga on grc_nga.idt  = {$AliasPric}.idt_grupo_atendimento";

// $sql .= " left join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_consultor ";
$sql .= " left  join plu_usuario plu_usuc on plu_usuc.id_usuario = {$AliasPric}.idt_consultor";
$sql .= " left  join plu_usuario plu_usud on plu_usud.id_usuario = {$AliasPric}.idt_digitador";
$sql .= " left  join plu_usuario plu_usut on plu_usut.id_usuario = {$AliasPric}.idt_nan_tutor";
$sql .= " left  join plu_usuario plu_usue on plu_usue.id_usuario = {$AliasPric}.idt_nan_empresa";
//
$sql .= " left  join grc_projeto      grc_p  on grc_p.idt  = {$AliasPric}.idt_projeto";
$sql .= " left  join grc_projeto_acao grc_pa on grc_pa.idt = {$AliasPric}.idt_projeto_acao";

$sql .= " left  outer join ".db_pir."sca_organizacao_secao sca_s on sca_s.idt = {$AliasPric}.idt_ponto_atendimento";

$sql .= " left  outer join ".db_pir."sca_organizacao_secao sca_u on sca_u.idt = {$AliasPric}.idt_unidade";


$sql .= " left join grc_atendimento_instrumento grc_ai on grc_ai.idt = {$AliasPric}.idt_instrumento ";

$sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = {$AliasPric}.idt and ap.tipo_relacao = 'L'";
$sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = {$AliasPric}.idt and ao.representa = 'S' and ao.desvincular = 'N'";

$sql .= " left outer join ".db_pir_gec."gec_entidade_sexo gec_s  on gec_s.idt = ap.idt_sexo";
$sql .= " left outer join ".db_pir_gec."gec_entidade_grau_formacao  gec_es on gec_es.idt = ap.idt_escolaridade";
$sql .= " left outer join ".db_pir_gec."gec_organizacao_porte op on op.idt = ao.idt_porte";

$sql .= " left outer join ".db_pir_siac."cargcli car on car.codcargcli = ao.representa_codcargcli";


$sql .= " left outer join ".db_pir_gec."cnae cn on cn.subclasse = ao.idt_cnae_principal";

$sql .= " left outer join ".db_pir_gec."gec_entidade_setor st on st.idt = ao.idt_setor";
$sql .= " left outer join ".db_pir_gec."gec_entidade_tipo_emp ete on ete.idt = ao.idt_tipo_empreendimento";

$sql .= " left join grc_evento grc_ev on grc_ev.idt = {$AliasPric}.idt_evento ";

$sql .= " left join grc_produto grc_prod on grc_prod.idt = grc_ev.idt_produto ";


$sql .= " left join grc_evento_situacao grc_evs on grc_evs.idt = grc_ev.idt_evento_situacao ";
$sql .= " left join grc_projeto grc_proj on grc_proj.idt = grc_ev.idt_projeto ";
$sql .= " left join grc_projeto_situacao grc_projs on grc_projs.idt = grc_proj.idt_projeto_situacao ";

$sql .= " left join grc_projeto_acao grc_proja on grc_proja.idt = grc_ev.idt_acao ";


$sql .= " left  outer join ".db_pir."sca_organizacao_secao sca_eve_pa on sca_eve_pa.idt = grc_ev.idt_ponto_atendimento";

$sql .= " left  outer join ".db_pir."sca_organizacao_secao sca_eve_u on sca_eve_u.idt = grc_ev.idt_unidade";

$sql .= " left  join plu_usuario plu_usuge on plu_usuge.id_usuario = grc_ev.idt_gestor_evento";




$sql .= " left outer join ".db_pir_siac."cidade cid on cid.codcid = grc_ev.idt_cidade ";
$sql .= " left outer join grc_evento_local_pa loc on loc.idt = grc_ev.idt_local ";






$sql .= " left join grc_evento_participante grc_evp on grc_evp.idt_atendimento = {$AliasPric}.idt ";



//$dt_iniw = trata_data($vetFiltro['dt_ini']['valor']);
//$dt_fimw = trata_data($vetFiltro['dt_fim']['valor']);


$dt_iniw = trata_data($vetFiltro['atendimento']['valor_ini']);
$dt_fimw = trata_data($vetFiltro['atendimento']['valor_fim']);







$sql .= ' where ';
$sql .= " {$AliasPric}.data >= ".aspa($dt_iniw)." and {$AliasPric}.data <=  ".aspa($dt_fimw)." ";

// Atendimento se entende como 
// Só Balcao

if ($vetFiltro['tipoatendimento']['valor']!="Todos" )
{
	if ($vetFiltro['tipoatendimento']['valor']=="Balcao" )
	{
		$sql .= " and {$AliasPric}.idt_evento is null";
		$sql .= " and {$AliasPric}.idt_grupo_atendimento is null";
		$sql .= " and substring({$AliasPric}.protocolo,1,3) <> 'ATD' ";
	}
	if ($vetFiltro['tipoatendimento']['valor']=="Distancia" )
	{
		$sql .= " and {$AliasPric}.idt_evento is null";
		$sql .= " and {$AliasPric}.idt_grupo_atendimento is null";
		$sql .= " and substring({$AliasPric}.protocolo,1,3) = 'ATD' ";
	}
    if ($vetFiltro['tipoatendimento']['valor']=="NAN" )
	{
		$sql .= " and {$AliasPric}.idt_grupo_atendimento is not null";
	}	
	if ($vetFiltro['tipoatendimento']['valor']=="Evento" )
	{
		$sql .= " and {$AliasPric}.idt_evento is not null";
	}

}

//$sql .= " and {$AliasPric}.idt_instrumento= ".null($idt_instrumento);
if ($qtdcamposescolhidos == 0)
{
    $sql .= "  and 2 = 1 ";
}


if ($vetFiltro['status']['valor']!="Todos" and $vetFiltro['tipoatendimento']['valor']!="Evento")
{
    $sql .= " and ( {$AliasPric}.situacao = ".aspa($vetFiltro['status']['valor'])." ) " ;
}


if ($vetFiltro['idt_unidade_regional']['valor'] != '' AND $vetFiltro['idt_unidade_regional']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_unidade = ".null($vetFiltro['idt_unidade_regional']['valor'])." ) " ;
}

if ($vetFiltro['idt_ponto_atendimento']['valor'] != '' AND $vetFiltro['idt_ponto_atendimento']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_ponto_atendimento= ".null($vetFiltro['idt_ponto_atendimento']['valor']);
}

if ($vetFiltro['idt_projeto']['valor'] != '' AND $vetFiltro['idt_projeto']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_projeto = ".null($vetFiltro['idt_projeto']['valor'])." ) " ;
}
if ($vetFiltro['idt_projeto_acao']['valor'] != '' AND $vetFiltro['idt_projeto_acao']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_projeto_acao = ".null($vetFiltro['idt_projeto_acao']['valor'])." ) " ;
}

if ($vetFiltro['idt_tutor']['valor'] != '' AND $vetFiltro['idt_tutor']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_nan_tutor = ".null($vetFiltro['idt_tutor']['valor']);
}
if ($vetFiltro['idt_agente']['valor'] != '' AND $vetFiltro['idt_agente']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_consultor= ".null($vetFiltro['idt_agente']['valor']);
}
if ($vetFiltro['idt_empresa_executora']['valor'] != '' AND $vetFiltro['idt_empresa_executora']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_nan_empresa = ".null($vetFiltro['idt_empresa_executora']['valor']);
}

if ($vetFiltro['idt_porte']['valor'] != '' AND $vetFiltro['idt_porte']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " (ao.idt_porte = ".null($vetFiltro['idt_porte']['valor'])." ) " ;
}

if ($vetFiltro['idt_motivo_desistencia']['valor'] != '' AND $vetFiltro['idt_motivo_desistencia']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_motivo_desistencia = ".null($vetFiltro['idt_motivo_desistencia']['valor'])." ) " ;
}


if ($vetFiltro['numero_visitas']['valor'] != '' AND $vetFiltro['numero_visitas']['valor'] != '0') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.nan_num_visita = ".aspa($vetFiltro['numero_visitas']['valor'])." ) " ;
}




/*
if ($vetFiltro['status']['valor']!="" and $vetFiltro['status']['valor']!="0")
{
    $sql .= " and ( grc_nga.status = ".aspa($vetFiltro['status']['valor'])." ) " ;
    //$sql .= " and ( grc_nga.status = ".aspa('EV')." or grc_nga.status = ".aspa('AP')." ) " ;
}	


if ($vetFiltro['idt_ponto_atendimento']['valor'] != '' AND $vetFiltro['idt_ponto_atendimento']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " {$AliasPric}.idt_ponto_atendimento= ".null($vetFiltro['idt_ponto_atendimento']['valor']);
}

if ($vetFiltro['idt_consultor']['valor'] != '' AND $vetFiltro['idt_consultor']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " ({$AliasPric}.idt_consultor= ".null($vetFiltro['idt_consultor']['valor'])." or {$AliasPric}.idt_consultor is null or {$AliasPric}.idt_consultor = 0)";
}
if ($vetFiltro['idt_porte']['valor'] != '' AND $vetFiltro['idt_porte']['valor'] != '-1') {
    $sql .= ' and ';
    $sql .= " (ao.idt_porte = ".null($vetFiltro['idt_porte']['valor'])." ) " ;
}
*/

if ($instrumento == 500) {
    if ($vetFiltro['protocolo']['valor'] != "") {
        $sql .= ' and ';
        $sql .= ' ( ';
        $sql .= '  lower('.$AliasPric.'.protocolo)      like lower('.aspa($vetFiltro['protocolo']['valor'], '%', '%').')';
        $sql .= ' ) ';
    }
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.senha_totem)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.assunto) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.protocolo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($_POST['md5_vetcampo'] != md5(serialize($vetCampo))) {
    $_REQUEST['sqlOrderby'] = "";
    $_GET['sqlOrderby']     = "";
    $_POST['sqlOrderby']    = "";
    $_POST['sql_orderby']   = "";
}
//p($_POST['sql_orderby']);
$Filtro = Array();
$Filtro['rs']    = 'Hidden';
$Filtro['id']    = 'md5_vetcampo';
$Filtro['valor'] = md5(serialize($vetCampo));
$vetFiltro['md5_vetcampo'] = $Filtro;



?>
<script type="text/javascript">




    var diasint = 15;

    $(document).ready(function () {
        $("#filtro_id_usuario").cascade("#filtro_ponto_atendimento", {ajax: {
                url: ajax_sistema + '?tipo=pa_consultor&cas=' + conteudo_abrir_sistema
            }});

        $('#filtro_dt_ini, #filtro_dt_fim').change(function () {
            valida_dt();
        });
        // Instrumento
        var id = 'instrumento2';
        objtp = document.getElementById(id);
        if (objtp != null) {
            objtp.value = instrumento;
        }

        /*
         var id='div_'+instrumento+'_img';
         objtp = document.getElementById(id);
         if (objtp != null) {
         $(objtp).css('borderColor','#0000FF');
         }
         */
        //document.frm.submit();



    });

    function valida_dt() {
        if (validaDataMaior(false, $('#filtro_dt_fim'), 'Dt. Fim', $('#filtro_dt_ini'), 'Dt. Inicio') === false) {
            $('#filtro_dt_fim').val('');
            $('#filtro_dt_fim').focus();
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

    function fncListarCmbMuda_idt_projeto() {
        $('#idt_acao_bt_limpar').click();
    }

    function parListarCmb_idt_acao() {
        var par = '';

        if ($('#idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#idt_projeto').val();
        }

        return par;
    }

</script>
