<?php
$idCampo = 'idt';
$Tela = "a Ação do Projeto";
//

$TabelaPai   = "grc_projeto";
$AliasPai    = "grc_pro";
$EntidadePai = "Projeto";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_projeto_acao";
$AliasPric        = "grc_atdp";
$Entidade         = "Ação do Projeto";
$Entidade_p       = "Ações do Projeto";
$CampoPricPai     = "idt_projeto";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';


$comfiltro        = 'A';
$comidentificacao = 'F';

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_con_ap = true;
$barra_exc_ap = false;
$barra_fec_ap = false;
if ($_SESSION[CS]['g_id_usuario']==1)
{
$barra_alt_ap = true;
}


//
$Filtro = Array();
//$Filtro['campo']  = 'descricao';
//$Filtro['tabela'] = $TabelaPai;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadePai;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricPai] = $Filtro;
//
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;
//
    $texto="";
    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $codigo    = $rowt['codigo'];
            $descricao = $rowt['descricao'];
        }
    }
    $texto=" $codigo - $descricao ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);

 $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_projeto', $texto);

//Monta o vetor de Campo
/*
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['grc_ps_descricao'] = CriaVetTabela('Ação');
$vetCampo['descricao'] = CriaVetTabela('Complemento');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['data_inicio']  = CriaVetTabela('Data Inicio','data');
$vetCampo['data_termino']  = CriaVetTabela('Data Termino','data');
$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Criado por:');
$vetCampo['codigo_sge'] = CriaVetTabela('Cod.SGE');
*/
$vetCampo['descricao']       = CriaVetTabela('Título da Ação');
$vetCampo['detalhe']         = CriaVetTabela('Descrição');
$vetCampo['existe_siacweb']  = CriaVetTabela('Existe SIACWEB?', 'descDominio', $vetSimNao );
$vetCampo['ativo_siacweb']   = CriaVetTabela('Ativo SIACWEB?', 'descDominio', $vetSimNao );
$vetCampo['codigo_siacweb']  = CriaVetTabela('Código SIACWEB?');
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       grc_ps.descricao as grc_ps_descricao, ";
$sql  .= "  plu_usu.nome_completo as plu_usu_nome_completo ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql .= " inner left grc_projeto_acao_n grc_ps on grc_ps.idt = {$AliasPric}.idt_projeto_acao_n ";
$sql .= " inner left plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_usuario_criador ";

//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';


if ($sqlOrderby == '') {
        $sqlOrderby = "descricao asc";
}


//$orderby = "{$AliasPric}.codigo";

//$sql .= " order by {$orderby}";
?>