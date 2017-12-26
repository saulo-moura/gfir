<?php
$idCampo = 'idt';
$Tela = "o CNAE da Entidade";
//




$TabelaAvo   = "gec_entidade";
$AliasAvo    = "gec_en";
$EntidadeAvo = "Entidade";
$idAvo       = "idt";



$TabelaPai   = "gec_entidade_organizacao";
$AliasPai    = "gec_eno";
$EntidadePai = "Dados da Entidade Organização";
$idPai       = "idt";

//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);


//
$TabelaPrinc      = "gec_entidade_cnae";
$AliasPric        = "gec_ecn";
$Entidade         = "CNAE da Entidade";
$Entidade_p       = "CNAEs da Entidade";

$CampoPricAvo     = "idt_entidade";
$CampoPricPai     = "idt_entidade_organizacao";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";




$Filtro = Array();
$Filtro['campo']  = 'descricao';
$Filtro['tabela'] = $TabelaAvo;
$Filtro['id']     = 'idt';
$Filtro['nome']   = $EntidadeAvo;
$Filtro['valor']  = trata_id($Filtro);
$vetFiltro[$CampoPricAvo] = $Filtro;

//
$Filtro = Array();
$Filtro['campo']  = 'inscricao_estadual';
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
$orderby = " {$AliasPric}.principal desc, cn.codigo ";
//Monta o vetor de Campo



$veio = $_SESSION[CS][$TabelaPai]['veio'];
//if ($veio=="O")
//{
    //$upCad = vetCad('idt', 'Organização', 'gec_organizacao');
//    $sql = 'select descricao from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
//    $rst = execsql($sql);
//    $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_organizacao', $rst->data[0][0]);


//    $sql = 'select descricao from '.$TabelaAvo.' where idt = '.null($vetFiltro[$CampoPricAvo]['valor']);
//    $rst = execsql($sql);
//    $upCad[] = vetCadUp('idt,idt', 'Entidade', 'gec_entidade',$rst->data[0][0]);
    
    
    $sql = 'select descricao from '.$TabelaAvo.' where idt = '.null($vetFiltro[$CampoPricAvo]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $descricao = $rowt['descricao'];
        }
    }
    $texto=" $descricao ";
    $upCad[] = vetCadUp('idt,idt', 'Entidade', $TabelaAvo,$texto);


    
    $sql = 'select inscricao_estadual from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $inscricao_estadual = $rowt['inscricao_estadual'];
        }
    }
    $texto=" $inscricao_estadual ";
    $upCad[] = vetCadUp('idt,idt', 'Dados da Organizacao', $TabelaPai,$texto);

   // p($upCad);

//    $sql = 'select * from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
//    $rst = execsql($sql);

    //$upCad[] = vetCadUp('idt', $EntidadePai, 'gec_organizacao', $rst->data[0][0]);

    //$upCad[] = vetCadUp('idt,idt', 'Dados da Organização', 'gec_entidade_organizacao',$rst->data[0][0]);
//}
//else
//{
//    $upCad = vetCad('idt', 'Pessoa', 'gec_pessoa');
//}









$vetCampo['principal']          = CriaVetTabela('Principal?', 'descDominio', $vetSimNao );
$vetCampo['cn_descricao']       = CriaVetTabela('CNAE');

//
$sql  = "select {$AliasPric}.*, ";
$sql .= "        cn.descricao as cn_descricao ";
//
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " inner join cnae cn on  cn.subclasse = {$AliasPric}.cnae ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(cn.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(cn.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";
?>