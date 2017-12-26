<?php
$tabela = 'plu_usuario';
$id = 'id_usuario';

if ($_GET['id'] == 0) {
    $vetCampo['nome_completo'] = objTexto('nome_completo', 'Nome Completo', True, 50, 120);
    $vetCampo['login'] = objTexto('login', 'Login', True, 30, 120);
    $vetCampo['senha'] = objHidden('senha', md5($vetConf['senha_padrao']));
    $vetCampo['email'] = objEmail('email', 'e-mail', True, 40, 60);
    $vetCampo['ldap'] = objCmbVetor('ldap', 'Login usando o AD?', True, $vetSimNao);
} else {
    $vetCampo['nome_completo'] = objTextoFixo('nome_completo', 'Nome Completo', 50, true);
    $vetCampo['login'] = objTextoFixo('login', 'Login', 30, true);
    $vetCampo['email'] = objTextoFixo('email', 'e-mail', 40, True);
    $vetCampo['ldap'] = objFixoVetor('ldap', 'Login usando o AD?', True, $vetSimNao);
}

$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo', True, $vetSimNao);
$vetCampo['mostra_menu'] = objCmbVetor('mostra_menu', 'Mostra Menu?', True, $vetSimNao);
$vetCampo['mostra_barra_home'] = objCmbVetor('mostra_barra_home', 'Mostra barra no Home?', True, $vetSimNao);

$sql = 'select id_perfil, nm_perfil from '.$pre_table.'plu_perfil order by nm_perfil';
$vetCampo['id_perfil'] = objCmbBanco('id_perfil', 'Perfil GC', True, $sql);

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






$vetCampo['gestor_produto'] = objCmbVetor('gestor_produto', 'Gestor de Produto', True, $vetNaoSim, '');

$sql = "select idt, classificacao, descricao from ".db_pir."sca_organizacao_secao sca_os where posto_atendimento = 'S' order by classificacao";
$vetCampo['idt_unidade_regional'] = objCmbBanco('idt_unidade_regional', 'Ponto de Atendimento', false, $sql, ' ', 'width:430px;');

$sql = "select idt, classificacao, descricao from ".db_pir."sca_organizacao_secao sca_os order by classificacao";
$vetCampo['idt_unidade_lotacao'] = objFixoBanco('idt_unidade_lotacao', 'Unidade de Lota��o', db_pir.'sca_organizacao_secao', 'idt', 'classificacao, descricao');

$vetCampo['idt_projeto'] = objListarCmb('idt_projeto', 'grc_projeto', 'Projeto', false, '442px');
$vetCampo['idt_acao'] = objListarCmb('idt_acao', 'grc_projeto_acao', 'A��o', false, '442px');
$vetCampo['gestor_sge'] = objTextoFixo('gestor_sge', 'Gestor SGE', 50, true);
$vetCampo['fase_acao_projeto'] = objTextoFixo('fase_acao_projeto', 'Fase', 50, true);



$sql = 'select ';
$sql .= '   scaoc.idt,  ';

$sql .= '   est.codigo as est_codigo, ';
$sql .= '   scaos.localidade,  ';
// $sql  .= '   scaoc.agrupamento,  ';
$sql .= '   scaos.descricao,  ';
$sql .= '   scaoc.descricao  ';

$sql .= ' from sca_organizacao_secao as scaos ';
$sql .= ' left join plu_estado est on est.idt = scaos.idt_estado ';
$sql .= ' left join sca_organizacao_cargo scaoc on scaoc.idt_secao = scaos.idt ';
$sql .= ' order by est.descricao, scaos.descricao, scaoc.descricao ';



$vetCampo['idt_cargo'] = objCmbBanco('idt_cargo', 'Cargo', False, $sql, '', 'width:400px;');

$vetCampo['marketing'] = objCmbVetor('marketing', 'Perfil de Marketing?', false, $vetSimNao);


$vetCampo['trancar_gantt'] = objCmbVetor('trancar_gantt', 'Trancar Gantt?', false, $vetSimNao);



$vetCampo['dt_validade_inicio'] = objData('dt_validade_inicio', 'V�lido de', False);
$vetCampo['dt_validade'] = objData('dt_validade', 'V�lido at�', False);

$sql = 'select id_perfil, nm_perfil from '.$pre_table.'plu_site_perfil order by nm_perfil';
$vetCampo['id_site_perfil'] = objCmbBanco('id_site_perfil', 'Perfil - Site', false, $sql);

$vetCampo['telefone'] = objTelefone('telefone', 'Telefone', false, 45, 45);

$vetTpessoa = Array();
$vetTpessoa['A'] = 'Administrador';
$vetTpessoa['P'] = 'Usu�rios';
$vetTpessoa['F'] = 'Visitantes';
//$vetTpessoa['J']='Solicitantes - Pessoa Jur�dica';
$vetCampo['tipo_usuario'] = objCmbVetor('tipo_usuario', 'Tipo Usu�rio', True, $vetTpessoa);
$vetCampo['confirma_login'] = objCmbVetor('confirma_login', 'Confirma Login?', True, $vetSimNao);


$vetCampo['gestor_login'] = objCmbVetor('gestor_login', 'Gestor Autoriza��o?', false, $vetSimNao);


$vetSit = Array();
$vetSit['00'] = 'Login Cadastrado';
$vetSit['01'] = 'Novo Login';
$vetSit['02'] = 'Login Atualizado';
$vetSit['20'] = 'Login Desativado';
$vetCampo['situacao_login'] = objCmbVetor('situacao_login', 'Situa��o Login', True, $vetSit);

$vetCampo['gerenciador'] = objCmbVetor('gerenciador', 'Acesso ao<br /> Gerenciador de Conte�do?', True, $vetSimNao);


$vetObra = Array();
$vetObra['0'] = 'Todas as Obras';
$vetObra['1'] = 'Obra(s) especificada(s)';
$vetCampo['acesso_obra'] = objCmbVetor('acesso_obra', 'Acesso a Obras', True, $vetObra);

$vetCampo['gestor_obra'] = objCmbVetor('gestor_obra', 'Gestor de Obras', True, $vetSimNao);
$vetCampo['procedimento'] = objCmbVetor('procedimento', 'Acessa Procedimentos?', True, $vetSimNao);


$sql_lst_1 = 'select em.idt as idt_empreendimento,  sacsi.descricao, sacsi.sigla, em.descricao  from empreendimento em ';
$sql_lst_1 .= ' inner join sca_sistema sacsi on sacsi.idt = em.idt_sistema';
$sql_lst_1 .= ' order by sacsi.descricao, em.descricao';

//$sql_lst_2  = 'select d.idt , df.idt_usuario_empreendimento, d.descricao from empreendimento d inner join
//               plu_usuario_empreendimento df on d.idt = df.idt_empreendimento
//               where df.id_usuario = '.$_GET['id'].' order by d.descricao';
$sql_lst_2 = 'select d.idt ,  sacsi.descricao, sacsi.sigla, d.descricao from empreendimento d
               inner join
               sca_sistema sacsi on sacsi.idt = d.idt_sistema
               inner join
               plu_usuario_empreendimento df on d.idt = df.idt_empreendimento
               where df.id_usuario = '.$_GET['id'].' order by d.descricao';

$vetCampo['idt_empreendimento'] = objLista('idt_empreendimento', False, 'Sistemas e Ambientes', 'empreendimento', $sql_lst_1, 'plu_usuario_empreendimento', 290, 'Sistemas e Ambientes de Acesso', 'obra', $sql_lst_2, '', '', 'plu_usuario_empreendimento', '', 'id_usuario');

$vetCampo['matricula_intranet'] = objTexto('matricula_intranet', 'Matr�cula (para Funcion�rios)', false, 15, 20);

if ($veiodeonde == 'S') {
    $sql_lst_3 = 'select idt as idt_empreendimento, estado, descricao  from empreendimento order by estado, descricao';
    $sql_lst_4 = 'select d.idt , df.idt_usuario_empreendimento, d.descricao from empreendimento d inner join
                   plu_usuario_assinatura df on d.idt = df.idt_empreendimento
                   where df.id_usuario = '.$_GET['id'].' order by d.descricao';
    $vetCampo['idt_empreendimento_a'] = objLista('idt_empreendimento_a', False, 'Sistemas e Ambientes', 'empreendimento', $sql_lst_3, 'usuario_assinatura', 290, 'Obras a Assinar', 'obra', $sql_lst_4, '', '', 'usuario_assinatura', 'id_usuario');
}
$sql = 'select idt, codigo, descricao from '.$pre_table.'plu_usuario_natureza order by codigo';
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', false, $sql, ' -- Selecione --');

$vetCampo['alt_status_produto'] = objCmbVetor('alt_status_produto', 'Alterar a Situa��o do Produto', True, $vetSimNao);
$vetCampo['evento_sincroniza_rm'] = objCmbVetor('evento_sincroniza_rm', 'Poder colocar o Evento SGTEC para Evento para meta f�sica', True, $vetSimNao);
$vetCampo['evento_muda_dt_real_ini_hist'] = objCmbVetor('evento_muda_dt_real_ini_hist', 'Poder mudar a Data de Realiza��o de In�cio do Evento', True, $vetSimNao);

$vetCampo['cpf'] = objCPF('cpf', 'CPF', false);
$vetCampo['codparceiro_siacweb'] = objHidden('codparceiro_siacweb', '', 'C�digo SiacWeb', true);

$vetCampo['evento_canal_registro'] = objTexto('evento_canal_registro', 'Descri��o do Canal do Registro para Inscri��o no Evento', false, 45);

MesclarCol($vetCampo['idt_natureza'], 3);
MesclarCol($vetCampo['nome_completo'], 3);
MesclarCol($vetCampo['login'], 3);
MesclarCol($vetCampo['ativo'], 3);
MesclarCol($vetCampo['email'], 3);
MesclarCol($vetCampo['telefone'], 3);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_natureza'], '', $vetCampo['nome_completo']),
    Array($vetCampo['login'], '', $vetCampo['ldap'], '', $vetCampo['senha']),
    Array($vetCampo['ativo'], '', $vetCampo['id_perfil'], '', $vetCampo['id_site_perfil']),
    Array($vetCampo['email'], '', $vetCampo['telefone']),
    Array($vetCampo['dt_validade_inicio'], '', $vetCampo['dt_validade'], '', $vetCampo['cpf'], '', $vetCampo['codparceiro_siacweb']),
        ));

MesclarCol($vetCampo['matricula_intranet'], 11);
$vetFrm[] = Frame('', Array(
    //  Array($vetCampo['id_site_perfil'], ' ', $vetCampo['gestor_obra'], ' ', $vetCampo['procedimento']),
    //Array($vetCampo['id_site_perfil']),
//  Array($vetCampo['idt_cargo'], ' ',$vetCampo['matricula_intranet']),
    Array($vetCampo['matricula_intranet']),
    Array($vetCampo['tipo_usuario'], '', $vetCampo['situacao_login'], '', $vetCampo['gerenciador'], '', $vetCampo['gestor_login'], '', $vetCampo['mostra_menu'], '', $vetCampo['mostra_barra_home']),
        ));





MesclarCol($vetCampo['idt_projeto'], 3);
MesclarCol($vetCampo['idt_acao'], 3);
MesclarCol($vetCampo['evento_canal_registro'], 5);

$vetFrm[] = Frame('Par�metros do Login', Array(
    Array($vetCampo['gestor_produto'], '', $vetCampo['idt_unidade_lotacao'], '', $vetCampo['idt_unidade_regional']),
    Array($vetCampo['idt_projeto'], '', $vetCampo['gestor_sge']),
    Array($vetCampo['idt_acao'], '', $vetCampo['fase_acao_projeto']),
    Array($vetCampo['alt_status_produto'], '', $vetCampo['evento_sincroniza_rm'], '', $vetCampo['evento_muda_dt_real_ini_hist']),
    Array($vetCampo['evento_canal_registro']),
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

/*
  $vetFrm[] = Frame('', Array(
  Array($vetCampo['idt_empreendimento'])
  ));
  if ($veiodeonde=='S')
  {
  $vetFrm[] = Frame('', Array(
  Array($vetCampo['idt_empreendimento_a'])
  ));
  }
 */

//$vetFrm[] = Frame('', Array(
//    Array($vetCampo['id_site_perfil']),
//));



$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cpf').change(function () {
            if ($(this).val() != '') {
                processando();

                $('#codparceiro_siacweb').val('');
                $('#codparceiro_siacweb_fix').text('');

                $.ajax({
                    type: 'POST',
                    url: ajax_sistema + '?tipo=cpf_codparceiro_siacweb',
                    data: {
                        cas: conteudo_abrir_sistema,
                        cpf: $(this).val()
                    },
                    success: function (response) {
                        var cod = parseInt(response);

                        if (isNaN(cod)) {
                            $("#dialog-processando").remove();
                            alert(response);
                        } else {
                            $('#codparceiro_siacweb').val(cod);
                            $('#codparceiro_siacweb_fix').text(cod);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#dialog-processando").remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $("#dialog-processando").remove();
            }
        });
    });

    function fncListarCmbMuda_idt_projeto(idt_projeto) {
        $('#idt_acao_bt_limpar').click();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=projeto_dados',
            data: {
                cas: conteudo_abrir_sistema,
                idt_projeto: idt_projeto
            },
            success: function (response) {
                $('#gestor_sge').val(url_decode(response.gestor));
                $('#fase_acao_projeto').val(url_decode(response.etapa));

                $('#gestor_sge_fix').html(url_decode(response.gestor));
                $('#fase_acao_projeto_fix').html(url_decode(response.etapa));

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
    }

    function parListarCmb_idt_acao() {
        var par = '';

        if ($('#idt_projeto').val() == '') {
            alert('Favor informar o Projeto!');
            return false;
        } else {
            par += '&idt_projeto=' + $('#idt_projeto').val();
        }

        return par;
    }
</script>