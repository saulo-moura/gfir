<?php
$tabela = 'usuario';
$id = 'id_usuario';

$vetCampo['nome_completo'] = objTexto('nome_completo', 'Nome Completo', True, 50,120);
$vetCampo['login'] = objTexto('login', 'Login', True, 30,120);

if ($_GET['id'] == 0)
    $vetCampo['senha'] = objHidden('senha', md5($vetConf['senha_padrao']));
else
    $vetCampo['senha'] = objCheckbox('senha', 'Senha', md5($vetConf['senha_padrao']), 'Mudar para o valor padrão.');

$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo', True, $vetSimNao);

$sql = 'select id_perfil, nm_perfil from '.$pre_table.'perfil order by nm_perfil';
$vetCampo['id_perfil'] = objCmbBanco('id_perfil', 'Perfil', True, $sql);

//$sql = 'select idt, classificacao, descricao from sca_estrutura order by classificacao';

/*
$sql   = 'select ';
$sql  .= '   scaoc.idt,  ';
$sql  .= '   est.codigo as est_codigo, ';
$sql  .= '   scaos.localidade,  ';
$sql  .= '   scaoc.agrupamento,  ';
$sql  .= '   scaoc.descricao  ';

$sql  .= ' from sca_organizacao_secao as scaos ';
$sql  .= ' left join estado est on est.idt = scaos.idt_estado ';
$sql  .= ' left join sca_organizacao_cargo scaoc on scaoc.idt_secao = scaos.idt ';
$sql  .= ' order by est.descricao, scaoc.agrupamento, scaoc.descricao ';
*/


$sql   = 'select ';
$sql  .= '   scaoc.idt,  ';

$sql  .= '   est.codigo as est_codigo, ';
$sql  .= '   scaos.localidade,  ';
// $sql  .= '   scaoc.agrupamento,  ';
$sql  .= '   scaos.descricao,  ';
$sql  .= '   scaoc.descricao  ';

$sql  .= ' from sca_organizacao_secao as scaos ';
$sql  .= ' left join estado est on est.idt = scaos.idt_estado ';
$sql  .= ' left join sca_organizacao_cargo scaoc on scaoc.idt_secao = scaos.idt ';
$sql  .= ' order by est.descricao, scaos.descricao, scaoc.descricao ';



$vetCampo['idt_cargo'] = objCmbBanco('idt_cargo', 'Cargo', False, $sql,'','width:400px;');

$vetCampo['marketing'] = objCmbVetor('marketing', 'Perfil de Marketing?', false, $vetSimNao);


$vetCampo['trancar_gantt'] = objCmbVetor('trancar_gantt', 'Trancar Gantt?', false, $vetSimNao);



$vetCampo['dt_validade'] = objData('dt_validade', 'Válido até', False);
$vetCampo['email'] = objEmail('email', 'e-mail', True, 40, 60);

$sql = 'select id_perfil, nm_perfil from '.$pre_table.'site_perfil order by nm_perfil';
$vetCampo['id_site_perfil'] = objCmbBanco('id_site_perfil', 'Site - Perfil', false, $sql);

$vetCampo['telefone'] = objTelefone('telefone', 'Telefone', false, 45, 45);

$vetTpessoa=Array();
$vetTpessoa['A']='Administrador';
$vetTpessoa['P']='Usuários';
$vetTpessoa['F']='Visitantes';
//$vetTpessoa['J']='Solicitantes - Pessoa Jurídica';
$vetCampo['tipo_usuario'] = objCmbVetor('tipo_usuario', 'Tipo Usuário', True, $vetTpessoa);
$vetCampo['confirma_login'] = objCmbVetor('confirma_login', 'Confirma Login?', True, $vetSimNao);


$vetCampo['gestor_login'] = objCmbVetor('gestor_login', 'Gestor Autorização?', false, $vetSimNao);


$vetSit=Array();
$vetSit['00']='Login Cadastrado';
$vetSit['01']='Novo Login';
$vetSit['02']='Login Atualizado';
$vetSit['20']='Login Desativado';
$vetCampo['situacao_login'] = objCmbVetor('situacao_login', 'Situação Login', True, $vetSit);

$vetCampo['gerenciador'] = objCmbVetor('gerenciador', 'Acesso ao Gerenciador de Conteúdo?', True, $vetSimNao);


$vetObra=Array();
$vetObra['0']='Todas as Obras';
$vetObra['1']='Obra(s) especificada(s)';
$vetCampo['acesso_obra'] = objCmbVetor('acesso_obra', 'Acesso a Obras', True, $vetObra);

$vetCampo['gestor_obra'] = objCmbVetor('gestor_obra', 'Gestor de Obras', True, $vetSimNao);
$vetCampo['procedimento'] = objCmbVetor('procedimento', 'Acessa Procedimentos?', True, $vetSimNao);


$sql_lst_1  = 'select em.idt as idt_empreendimento,  sacsi.descricao, sacsi.sigla, em.descricao  from empreendimento em ';
$sql_lst_1 .= ' inner join sca_sistema sacsi on sacsi.idt = em.idt_sistema';
$sql_lst_1 .= ' order by sacsi.descricao, em.descricao';

//$sql_lst_2  = 'select d.idt , df.idt_usuario_empreendimento, d.descricao from empreendimento d inner join
//               usuario_empreendimento df on d.idt = df.idt_empreendimento
//               where df.id_usuario = '.$_GET['id'].' order by d.descricao';
$sql_lst_2  = 'select d.idt ,  sacsi.descricao, sacsi.sigla, d.descricao from empreendimento d
               inner join
               sca_sistema sacsi on sacsi.idt = d.idt_sistema
               inner join
               usuario_empreendimento df on d.idt = df.idt_empreendimento
               where df.id_usuario = '.$_GET['id'].' order by d.descricao';

$vetCampo['idt_empreendimento'] = objLista('idt_empreendimento', False, 'Sistemas e Ambientes', 'empreendimento', $sql_lst_1, 'usuario_empreendimento', 290, 'Sistemas e Ambientes de Acesso', 'obra', $sql_lst_2, '', '', 'usuario_empreendimento', '' , 'id_usuario');

$vetCampo['matricula_intranet'] = objTexto('matricula_intranet', 'Matrícula', false, 15,20);

if ($veiodeonde=='S')
{
    $sql_lst_3  = 'select idt as idt_empreendimento, estado, descricao  from empreendimento order by estado, descricao';
    $sql_lst_4  = 'select d.idt , df.idt_usuario_empreendimento, d.descricao from empreendimento d inner join
                   usuario_assinatura df on d.idt = df.idt_empreendimento
                   where df.id_usuario = '.$_GET['id'].' order by d.descricao';
    $vetCampo['idt_empreendimento_a'] = objLista('idt_empreendimento_a', False, 'Sistemas e Ambientes', 'empreendimento', $sql_lst_3, 'usuario_assinatura', 290, 'Obras a Assinar', 'obra', $sql_lst_4, '', '', 'usuario_assinatura', 'id_usuario');
}
$sql = 'select idt, codigo, descricao from '.$pre_table.'plu_usuario_natureza order by codigo';
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', false, $sql,' -- Selecione --');


//MesclarCol($vetCampo['nome_completo'], 3);
MesclarCol($vetCampo['dt_validade'], 3);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_natureza'],'',$vetCampo['nome_completo']),
    Array($vetCampo['login'], '', $vetCampo['senha']),
    Array($vetCampo['ativo'], '', $vetCampo['id_perfil']),
    Array($vetCampo['email'], '', $vetCampo['telefone']),
    Array($vetCampo['dt_validade']),
));

MesclarCol($vetCampo['matricula_intranet'], 5);
$vetFrm[] = Frame('', Array(
  //  Array($vetCampo['id_site_perfil'], ' ', $vetCampo['gestor_obra'], ' ', $vetCampo['procedimento']),
  
  //Array($vetCampo['id_site_perfil']),
  Array($vetCampo['idt_cargo'], ' ',$vetCampo['matricula_intranet']),
  Array($vetCampo['tipo_usuario'], ' ', $vetCampo['situacao_login'],'',$vetCampo['gerenciador'],'',$vetCampo['gestor_login']),

  
));

MesclarCol($vetCampo['situacao_login'], 3);

//$vetFrm[] = Frame('', Array(
//    Array($vetCampo['tipo_usuario'], ' ', $vetCampo['gerenciador'], ' ', $vetCampo['situacao_login']),
//    Array($vetCampo['matricula_intranet'], ' ', $vetCampo['idt_setor'], ' ', $vetCampo['marketing'],'',$vetCampo['trancar_gantt']),


//    Array($vetCampo['tipo_usuario'], ' ', $vetCampo['gerenciador'], ' ', $vetCampo['situacao_login']),
//    Array($vetCampo['matricula_intranet'], ' ', $vetCampo['idt_setor']),



//));

MesclarCol($vetCampo['acesso_obra'], 3);

//$vetFrm[] = Frame('', Array(
//    Array($vetCampo['acesso_obra']),
//));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_empreendimento'])
));
if ($veiodeonde=='S')
{
    $vetFrm[] = Frame('', Array(
        Array($vetCampo['idt_empreendimento_a'])
    ));
}

$vetCad[] = $vetFrm;
?>