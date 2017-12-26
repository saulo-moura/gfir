<?php
$idCampo = 'idt';
$Tela = "a Agenda da Programação de Evento";
//

$TabelaPai   = "grc_evento";
$AliasPai    = "grc_ppr";
$EntidadePai = "Programação de Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_agenda";
$AliasPric        = "grc_eveper";
$Entidade         = "Agenda da Programação de Evento";
$Entidade_p       = "Agendas da Programação de Evento";
$CampoPricPai     = "idt_evento";


$barra_inc_h      = "Incluir um Novo Registro de {$Entidade}";
$contlinfim       = "Existem #qt {$Entidade_p}.";



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

$vetTipoAgenda = Array(
    'Consultoria' => 'Consultoria',
    'Instrutoria' => 'Instrutoria',
    'Ambos' => 'Ambos',
);


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
  
  
 $upCad[] = vetCadUp('idt', $EntidadePai.': ', 'grc_evento', $texto);

//Monta o vetor de Campo
$vetCampo['tipo_agenda']     = CriaVetTabela('Tipo Agenda', 'descDominio', $vetTipoAgenda );
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['nome_agenda'] = CriaVetTabela('Ítem');
$vetCampo['data_inicial']  = CriaVetTabela('Data Inicial <br />Agenda','data');
$vetCampo['data_final']  = CriaVetTabela('Data Final <br />Agenda','data');
$vetCampo['carga_horaria'] = CriaVetTabela('Carga Horaria');
$vetCampo['quantidade_horas_mes'] = CriaVetTabela('Quantidade<br>Horas</br>');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//
$sql  = "select {$AliasPric}.* ";

$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join {$TabelaPai} {$AliasPai} on  {$AliasPai}.idt = {$AliasPric}.{$CampoPricPai}";
//
$sql .= " where {$AliasPric}.{$CampoPricPai} = ".null($vetFiltro[$CampoPricPai]['valor']);
// $sql .= ' and  '.$AliasPric.'.codigo  ='."'Consultoria'";
$sql .= ' and ( ';
$sql .= ' lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' or lower('.$AliasPric.'.nome_agenda) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';

$sql .= ' ) ';

$orderby = "{$AliasPric}.codigo".","."{$AliasPric}.codigo";

$sql .= " order by {$orderby}";