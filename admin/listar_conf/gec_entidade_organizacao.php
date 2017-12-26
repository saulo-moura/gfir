<?php
$idCampo = 'idt';
$Tela = "o Dado da Organização";
//
$MenuPai     = "gec_organizacao";
$TabelaPai   = "gec_entidade";
$AliasPai    = "gec_en";
$EntidadePai = "Entidade";
$idPai       = "idt";

$veio = $_SESSION[CS][$TabelaPai]['veio'];
//
//$upCad   = vetCad('', $EntidadePai, $TabelaPai);


//
$TabelaPrinc      = "gec_entidade_organizacao";
$AliasPric        = "gec_eo";
$Entidade         = "Dado da Organização";
$Entidade_p       = "Dados da Organização";
$CampoPricPai     = "idt_entidade";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";




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

if ($veio=="O")
{

    //$prefixow    = 'listar';
    $prefixow    = 'cadastro';
    
    $mostrar    = true;
    $cond_campo = '';
    $cond_valor = '';

    $imagem     = 'imagens/cnae_16.gif';
    $goCad[] = vetCad('idt,idt,idt', 'CNAEs da Organização', 'gec_entidade_cnae', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);









    /*
    $sql = 'select descricao from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_organizacao', $rst->data[0][0]);
    */
//    $sql = 'select * from '.$TabelaPai1.' where idt = '.null($vetFiltro[$CampoPricPai1]['valor']);


    $sql = 'select descricao from '.$TabelaPai.' where idt = '.null($vetFiltro[$CampoPricPai]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $descricao = $rowt['descricao'];
        }
    }
    $texto=" $descricao ";
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', $MenuPai, $texto);


    //p($upCad);





    
/*
    $sql = 'select * from '.$TabelaPai1.' where idt = '.null($vetFiltro[$CampoPricPai1]['valor']);
    $rst = execsql($sql);
    if ($rst->rows != 0) {
        ForEach ($rst->data as $rowt) {
            $codigo    = $rowt['codigo'];
            $descricao = $rowt['descricao'];
            $data_inicial_publicacao  = trata_data($rowt['data_inicial_publicacao']);
            $data_final_publicacao    = trata_data($rowt['data_final_publicacao']);
        }
    }
    $texto=" $codigo - $descricao ( Inicio: $data_inicial_publicacao  Término:$data_final_publicacao) ";

  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
    $upCad[] = vetCadUp('idt', $EntidadePai1.': ', 'gec_edital', $texto);

  */
    
    
    
    
    
    
    

    
}
else
{
    $upCad[] = vetCadUp('idt', 'Pessoa', 'gec_pessoa', 'aslhfkas rgdg doishgoshd gdsfohgsdf oig');
}

//
$orderby = "{$AliasPric}.data_registro";
//Monta o vetor de Campo


$vetCampo['gec_onj_descricao']    = CriaVetTabela('Natureza Jurídica');
$vetCampo['gec_op_descricao']     = CriaVetTabela('Porte');
$vetCampo['gec_ot_descricao']     = CriaVetTabela('Tipo');


$vetCampo['data_registro']          = CriaVetTabela('Data Registro<br /> na Junta','data');
$vetCampo['registro_junta']         = CriaVetTabela('Número Registro<br /> na Junta');
$vetCampo['inscricao_estadual']     = CriaVetTabela('Inscrição Estadual');
$vetCampo['inscricao_municipal']     = CriaVetTabela('Inscrição Municipal');

$vetCampo['ativo']                  = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= '       gec_op.descricao as gec_op_descricao, ';
$sql  .= '       gec_ot.descricao as gec_ot_descricao, ';

$sql  .= '       gec_onj.descricao as gec_onj_descricao ';




$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";

$sql  .= " inner join gec_organizacao_porte gec_op on gec_op.idt = {$AliasPric}.idt_porte ";
$sql  .= " inner join gec_organizacao_tipo  gec_ot on gec_ot.idt = {$AliasPric}.idt_tipo ";

$sql  .= " inner join gec_organizacao_natureza_juridica  gec_onj on gec_onj.idt = {$AliasPric}.idt_natureza_juridica ";


//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.data_registro) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.registro_junta) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' or lower('.$AliasPric.'.inscricao_estadual) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.inscricao_municipal) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' ) ';
//$sql .= " order by {$orderby}";
?>