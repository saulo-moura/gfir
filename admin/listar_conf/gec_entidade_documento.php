<?php
$idCampo = 'idt';
$Tela = "o Documento da Entidade";
//
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";
$veio = $_SESSION[CS][$TabelaPai]['veio'];

if ($veio=="O")
{
    $upCad = vetCad('idt', 'Organizaчуo', 'gec_organizacao');
}
else
{
    $upCad = vetCad('idt', 'Pessoa', 'gec_pessoa');
}

$prefixow    = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt,idt', 'Arquivos', 'gec_entidade_documento_arquivo', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);


//
$TabelaPrinc      = "gec_entidade_documento";
$AliasPric        = "gec_ed";
$Entidade         = "Documento da Entidade";
$Entidade_p       = "Documentos da Entidade";
$CampoPricPai     = "idt_entidade";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";




//
$Filtro = Array();
$Filtro['campo']  = 'descricao';
$Filtro['tabela'] = $TabelaPai;
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
$orderby = "gec_d.descricao ";

//Monta o vetor de Campo
$vetCampo['gec_d_descricao']  = CriaVetTabela('Documento');
$vetCampo['observacao']       = CriaVetTabela('Observaчуo');
//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        gec_d.descricao as gec_d_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join gec_documento gec_d on  gec_d.idt = {$AliasPric}.idt_documento ";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_d.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_ed.observacao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";

//p($sql);


?>