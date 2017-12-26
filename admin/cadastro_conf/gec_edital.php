<style>
#nm_funcao_desc label{
}
#nm_funcao_obj {
}
.Tit_Campo {
}
.Tit_Campo_Obr {
}
fieldset.class_frame {
    background:#ECF0F1;
    border:1px solid #14ADCC;
}
div.class_titulo {
    background: #ABBBBF;
    border    : 1px solid #14ADCC;
    color     : #FFFFFF;
    text-align: left;
}
div.class_titulo span {
    padding-left:10px;
}
</style>

<?php
$tabela = 'gec_edital';
$id = 'idt';

//$onSubmitCon = ' gec_edital_con() ';

$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 120);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 50, 120);
$vetCampo['ano']       = objCmbVetor('ano', 'Ano', false, $vetAno,' ');
//
$sql  = "select idt, codigo, descricao from gec_edital_tipo  ";
$sql .= " order by codigo";
$vetCampo['idt_tipo'] = objCmbBanco('idt_tipo', 'Tipo de Edital', true, $sql,'','width:180px;');
$sql  = "select idt, codigo, descricao from gec_edital_situacao  ";
$sql .= " order by codigo";
$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação do Edital', true, $sql,'','width:180px;');


$sql  = "select idt, codigo, descricao from gec_programa ";
$sql .= " order by codigo";
$vetCampo['idt_programa'] = objCmbBanco('idt_programa', 'Programa', true, $sql,'','width:400px;');



$style = '';
$js    = " onchange = 'TipoServico();'";
$sql  = "select idt, codigo, descricao from gec_tipo_servico ";
$sql .= " order by codigo";
$vetCampo['idt_tipo_servico'] = objCmbBanco('idt_tipo_servico', 'Tipo Servico', true, $sql,' ','width:400px;',$js);


$num_id = '';
$style = '';
$js    = " onchange = 'AreaConhecimento();'";

$vetCampo['todas_areas'] = objCmbVetor('todas_areas', 'Todas Áreas?', false, $vetNaoSim,' ',$js,$style);



$vetCampo['arquivo'] = objFile('arquivo', 'Arquivio com Edital', false, 40, 'todos', '', '', 0, '', 'Teste de Descrição', 'class_file');


$vetCampo['permanente']              = objCmbVetor('permanente', 'Permanentemente Aberto?', false, $vetNaoSim,'');

$vetCampo['publica']                 = objCmbVetor('publica', 'Publica?', True, $vetSimNao,'');
$vetCampo['data_inicial_publicacao'] = objDatahora('data_inicial_publicacao', 'Inicio Publicação', False);
$vetCampo['data_final_publicacao']   = objDatahora('data_final_publicacao', 'Final Publicação', False);




/*
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['objeto'] = objTextArea('objeto', 'Objeto', false, $maxlength, $style, $js);
*/

$vetCampo['objeto'] = objHTML('objeto', 'Objeto', true);



$vetCampow=$vetCampo;

$class_frame_f   = "class_frame_f";
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;


$titulo_cadastro="EDITAL";

$vetFrm = Array();

$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha);


$vetParametros = Array(
    'codigo_frm' => 'parte01',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetParametros = Array(
    'codigo_pai' => 'parte01',
);



MesclarCol($vetCampo['idt_programa'], 7);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['ano'],'',$vetCampo['descricao'],'',$vetCampo['idt_situacao']),
    Array($vetCampo['permanente'],'',$vetCampo['data_inicial_publicacao'],'',$vetCampo['data_final_publicacao'],'',$vetCampo['idt_tipo']),
    
    Array($vetCampo['idt_programa']),

    
    
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>Arquivo do Edital</span>', Array(
    Array($vetCampo['arquivo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetFrm[] = Frame('<span>Objeto</span>', Array(
    Array($vetCampo['objeto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

// ----------------------- COMISSÃO


$vetParametros = Array(
    'codigo_frm' => 'comissao',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>2 - COMISSÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['gec_ent_descricao']  = CriaVetTabela('PESSOA');
$vetCampo['gec_edr_descricao']  = CriaVetTabela('RELAÇÃO');
$vetCampo['email']              = CriaVetTabela('EMAIL');
$vetCampo['telefone']           = CriaVetTabela('TELEFONES');


$titulo = 'Comissão do Edital';

$TabelaPrinc      = "gec_edital_comissao";
$AliasPric        = "gec_edc";
$Entidade         = "Comissão do Edital";
$Entidade_p       = "Comissões do Edital";
$CampoPricPai     = "idt_edital";

$orderby = "gec_edr.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "        concat_ws('<br />',email_1,email_2) as email, ";
$sql  .= "        concat_ws('<br />',telefone_1,telefone_2) as telefone, ";
$sql  .= "       gec_edr.descricao as gec_edr_descricao, ";
$sql  .= "       gec_ent.descricao as gec_ent_descricao  ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_edital_relacao gec_edr on gec_edr.idt = {$AliasPric}.idt_relacao ";
$sql .= " inner join gec_entidade       gec_ent on gec_ent.idt = {$AliasPric}.idt_pessoa ";
//
$sql .= " where {$AliasPric}".'.idt_edital = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_edital_comissao'] = objListarConf('gec_edital_comissao', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'comissao',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['gec_edital_comissao']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


//--------------------------------------- PROCESSOS


$vetParametros = Array(
    'codigo_frm' => 'processos',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>3 - PROCESSOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['numero']         = CriaVetTabela('Número');
$vetCampo['titulo']         = CriaVetTabela('Título');
$vetCampo['gec_edps_descricao']         = CriaVetTabela('Situação');

$vetCampo['titulo']         = CriaVetTabela('Objeto');


$titulo = 'Processos do Edital';

$TabelaPrinc      = "gec_edital_processo";
$AliasPric        = "gec_edp";
$Entidade         = "Processo do Edital";
$Entidade_p       = "Processos do Edital";
$CampoPricPai     = "idt_edital";

$orderby = "{$AliasPric}.numero";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_edps.descricao as gec_edps_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_edital_processo_situacao gec_edps on gec_edps.idt = {$AliasPric}.idt_situacao ";
//
$sql .= " where {$AliasPric}".'.idt_edital = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_edital_processo'] = objListarConf('gec_edital_processo', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'processos',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['gec_edital_processo']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

/////////////////////////
//--------------------------------------- dOCUMENTOS


$vetFrm[] = Frame('<span>Tipo de Serviço</span>', Array(
    Array($vetCampow['idt_tipo_servico']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetParametros = Array(
    'codigo_frm' => 'documentos',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>4 - DOCUMENTOS</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['gec_edo_descricao']  = CriaVetTabela('Documento');
$vetCampo['observacao']         = CriaVetTabela('Observação');


$titulo = 'Documentos do Edital';

$TabelaPrinc      = "gec_edital_documento";
$AliasPric        = "gec_eac";
$Entidade         = "Documento do Edital";
$Entidade_p       = "Documentos do Edital";
$CampoPricPai     = "idt_edital";

//$orderby = "{$AliasPric}.numero";
$orderby = "gec_edo.codigo";

$sql  = "select {$AliasPric}.*, ";
$sql  .= "       gec_edo.descricao as gec_edo_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_documento gec_edo on gec_edo.idt = {$AliasPric}.idt_documento ";
//
$sql .= " where {$AliasPric}".'.idt_edital = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_edital_documento'] = objListarConf('gec_edital_documento', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'documentos',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['gec_edital_documento']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


//--------------------------------------- Áreas de conhecimentos



$vetFrm[] = Frame('<span>Todas as Áreas?</span>', Array(
    Array($vetCampow['todas_areas']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);


$vetParametros = Array(
    'codigo_frm' => 'areacon',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>5 - ÁREAS DE CONHECIMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['gec_ac_descricao']  = CriaVetTabela('Área de Conhecimento');
$vetCampo['observacao']         = CriaVetTabela('Observação');


$titulo = 'Áreas de Conhecimento do Edital';

$TabelaPrinc      = "gec_edital_area_conhecimento";
$AliasPric        = "gec_eac";
$Entidade         = "Área de Conhecimento do Edital";
$Entidade_p       = "Áreas de Conhecimentodo Edital";
$CampoPricPai     = "idt_edital";

//$orderby = "{$AliasPric}.numero";
$orderby = "gec_ac.codigo";


$sql  = "select {$AliasPric}.*, ";
$sql .= "       gec_ac.descricao as gec_ac_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_area_conhecimento gec_ac on gec_ac.idt = {$AliasPric}.idt_area_conhecimento ";
//
$sql .= " where {$AliasPric}".'.idt_edital = $vlID';
$sql .= " order by {$orderby}";


$vetCampo['gec_edital_area_conhecimento'] = objListarConf('gec_edital_area_conhecimento', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'areacon',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['gec_edital_area_conhecimento']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

///////////////////////////






//--------------------------------------- Áreas de conhecimentos



$vetParametros = Array(
    'codigo_frm' => 'acompanhamento',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('<span>6 - ACOMPANHAMENTO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetCampo = Array();
$vetCampo['data']                 = CriaVetTabela('Data Ocorrência','data');
$vetCampo['gec_ep_descricao']     = CriaVetTabela('Peça');
$vetCampo['plu_u_nome_completo']  = CriaVetTabela('Responsável pelo Registro');
$vetCampo['demandante']           = CriaVetTabela('Demandante');
$vetCampo['ocorrencia']           = CriaVetTabela('Ocorrência');


$titulo = 'Acompanhamento do Edital';

$TabelaPrinc      = "gec_edital_acompanhamento";
$AliasPric        = "gec_eac";
$Entidade         = "Acompanhamento do Edital";
$Entidade_p       = "Acompanhamento do Edital";
$CampoPricPai     = "idt_edital";

//$orderby = "{$AliasPric}.numero";
$orderby = "{$AliasPric}.data desc, plu_u.nome_completo ";
//
$sql  = "select {$AliasPric}.*, ";
$sql  .= "       plu_u.nome_completo as plu_u_nome_completo, ";
$sql  .= "       gec_ep.descricao as gec_ep_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join gec_edital_peca gec_ep on gec_ep.idt = {$AliasPric}.idt_peca ";
$sql .= " inner join plu_usuario plu_u on plu_u.id_usuario = {$AliasPric}.idt_usuario ";
//
$sql .= " where {$AliasPric}".'.idt_edital = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['gec_edital_acompanhamento'] = objListarConf('gec_edital_acompanhamento', 'idt', $vetCampo, $sql, $titulo, true);

$vetParametros = Array(
    'codigo_pai' => 'acompanhamento',
    'width' => '100%',
);

$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['gec_edital_acompanhamento']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

///////////////////////////






$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
function AreaConhecimento()
{
   alert('teste de area ');
   return false;
}
function TipoServico()
{
   alert('teste de Tipo Servico ');
   return false;
}

</script>