<?php
$idCampo = 'idt';
$Tela = "os Usuários do PA";

$TabelaPrinc      = "grc_atendimento_pa_pessoa";
$AliasPric        = "grc_app";
$Entidade         = "PA do Usuário";
$Entidade_p       = "PA´s do Usuário";


$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';



$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

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
$Filtro['nome']     = 'Pontos de Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;



$vetAtivoPA=Array();
$vetAtivoPA['S']='Sim';
$vetAtivoPA['N']='Não';
$vetAtivoPA['T']='Todos';
$Filtro = Array();
$Filtro['rs']       = $vetAtivoPA;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ativo no PA?';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ativo_pa'] = $Filtro;



$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['pu_nome_completo'] = CriaVetTabela('Pessoa');

$vetCampo['grc_ab_descricao'] = CriaVetTabela('Guichê padrão');

$vetCampo['letra_painel'] = CriaVetTabela('Letra para<br /> senha do painel');

$vetRel = Array();
$vetRel['C'] = 'Consultor';
$vetRel['A'] = 'Atendente';
$vetRel['R'] = 'Recepcionista';
$vetCampo['relacao'] = CriaVetTabela('Função <br />de atendimento','descDominio',$vetRel);

$vetCampo['ativo_pa'] = CriaVetTabela('Ativo no PA?','descDominio',$vetSimNao);

$vetCampo['duracao'] = CriaVetTabela('Duração mínima <br />de atendimento (min)');

$sql   = "select ";
$sql  .= "   {$AliasPric}.*, ";
$sql  .= "   grc_ab.descricao as grc_ab_descricao,  ";
$sql  .= "   pu.nome_completo as pu_nome_completo  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join plu_usuario as pu on pu.id_usuario = .{$AliasPric}.idt_usuario ";
$sql  .= " left outer join grc_atendimento_box as grc_ab on grc_ab.idt = .{$AliasPric}.idt_box ";


$sql  .= ' where ';
$sql  .= ' idt_ponto_atendimento = '.null($vetFiltro['ponto_atendimento']['valor']);


if ($vetFiltro['ativo_pa']['valor']!="")
{
    if ($vetFiltro['ativo_pa']['valor']!="T")
    {
		$sql .= ' and ';
		$sql .= '  ( ';
		$sql .= '  ativo_pa = '.aspa($vetFiltro['ativo_pa']['valor']);
		$sql .= '  ) ';
	}	
}

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower(pu.nome_completo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($sqlOrderby == '') {
        $sqlOrderby = "pu_nome_completo asc";
}

?>
