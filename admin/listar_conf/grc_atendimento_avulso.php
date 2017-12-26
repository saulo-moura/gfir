<?php
$idCampo = 'idt';
$Tela = "o Atendimento Avulso";

$TabelaPrinc      = "grc_atendimento_avulso";
$AliasPric        = "grc_aa";
$Entidade         = "Atendimento Avulso";
$Entidade_p       = "Atendimentos Avulsos";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

// Descida para o nivel 2

$prefixow    = 'listar';
$mostrar    = false;
$cond_campo = '';
$cond_valor = '';




$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['LinhaUm']  = '-- Selecione o PA --';
$Filtro['nome']     = 'Pontos de Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


$vetCampo['tipo_pessoa']  = CriaVetTabela('Prioridade?', 'descDominio', $vetSimNao );
$vetCampo['protocolo']    = CriaVetTabela('Senha');
$vetCampo['nome']         = CriaVetTabela('Nome');
$vetCampo['assunto']      = CriaVetTabela('Assunto');

$vetCampo['data_atendimento']  = CriaVetTabela('Data <br />Atendimento','data');
$vetCampo['cpf']               = CriaVetTabela('CPF');
$vetCampo['cnpj']              = CriaVetTabela('CNPJ');

$vetCampo['telefone']          = CriaVetTabela('Telefone');
$vetCampo['celular']           = CriaVetTabela('Celular');




$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";


$fezwere=0;
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
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";


$orderby = " tipo_pessoa desc, data_atendimento";

if ($sqlOrderby == '') {
        $sqlOrderby = $orderby;
}






?>