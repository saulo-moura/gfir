<?php
$idCampo = 'idt';
$Tela = "o Processo do Edital";
//
$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";






//
$TabelaPrinc      = "gec_edital_processo";
$AliasPric        = "gec_edp";
$Entidade         = "Processo do Edital";
$Entidade_p       = "Processos do Edital";
$CampoPricPai     = "idt_edital";

$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";







$prefixow    = 'listar';
$mostrar    = true;
$cond_campo = '';
$cond_valor = '';
$imagem     = 'imagens/empresa_16.png';
$goCad[] = vetCad('idt,idt', 'Etapas do Edital', 'gec_edital_etapas', $prefixow, $mostrar, $imagem, $cond_campo, $cond_valor);







$orderby = "";

//$sql_orderby=Array();





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
            $data_inicial_publicacao  = trata_data($rowt['data_inicial_publicacao']);
            $data_final_publicacao    = trata_data($rowt['data_final_publicacao']);
        }
    }
    $texto=" $codigo - $descricao ( Inicio: $data_inicial_publicacao  Tйrmino:$data_final_publicacao) ";
    
  //  $upCad[] = vetCadUp('idt', $EntidadePai, 'gec_edital', $rst->data[0][0]);
  
  
    $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'gec_edital', $texto);




//Monta o vetor de Campo
$vetCampo['numero']         = CriaVetTabela('Nъmero');
$vetCampo['titulo']         = CriaVetTabela('Tнtulo');
$vetCampo['gec_edps_descricao']         = CriaVetTabela('Situaзгo');

$vetCampo['titulo']         = CriaVetTabela('Objeto');

//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_edps.descricao as gec_edps_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
$sql .= " inner join gec_edital_processo_situacao gec_edps on gec_edps.idt = {$AliasPric}.idt_situacao ";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.numero) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.titulo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.numero";

$sql .= " order by {$orderby}";
?>