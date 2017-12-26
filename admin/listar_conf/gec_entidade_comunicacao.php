<?php
$idCampo = 'idt';
$Tela = "a Comunicação da Entidade";
//




$TabelaAvo   = "gec_entidade";
$AliasAvo    = "gec_en";
$EntidadeAvo = "Entidade";
$idAvo       = "idt";



$TabelaPai   = "gec_entidade_endereco";
$AliasPai    = "gec_end";
$EntidadePai = "Dados do Endereço da Organização";
$idPai       = "idt";

//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);


//
$TabelaPrinc      = "gec_entidade_comunicacao";
$AliasPric        = "gec_eco";
$Entidade         = "Comunicação da Entidade";
$Entidade_p       = "Comunicação da Entidade";

$CampoPricAvo     = "idt_entidade";
$CampoPricPai     = "idt_endereco";


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
$Filtro['campo']  = 'logradouro';
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
$orderby = " {$AliasPric}.origem ";
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


    
    $sql = 'select logradouro from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $logradouro = $rowt['logradouro'];
        }
    }
    $texto=" $logradouro ";
    $upCad[] = vetCadUp('idt,idt', 'Endereço da Organizacao', $TabelaPai,$texto);

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

$vetCampo['origem']      = CriaVetTabela('LOCAL');
$vetCampo['telefone']  = CriaVetTabela('TELEFONE');
$vetCampo['sms']       = CriaVetTabela('SMS');
$vetCampo['email']     = CriaVetTabela('EMAIL');
$vetCampo['www']       = CriaVetTabela('WWW');

//
$sql  = "select {$AliasPric}.*, ";
$sql .= " concat_ws('<br/>',telefone_1,telefone_2) as telefone, ";
$sql .= " concat_ws('<br/>',sms_1,sms_2) as sms, ";
$sql .= " concat_ws('<br/>',email_1,email_2) as email, ";
$sql .= " concat_ws('<br/>',www_1,www_2) as www ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower(gec_eco.origem)        like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower(gec_eco.telefone_1) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
$sql .= " order by {$orderby}";
?>