<style>
    #nm_funcao_desc label{
    }

    #nm_funcao_obj {
    }

    .Tit_Campo {
    }

    .Tit_Campo_Obr {
    }

    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame {
        background: #FFFFFF;
        border:1px solid #2C3E50;
    }

    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }
    #grc_eve_objxxx {
        display:none;
    }


    #grc_eve_desc img:last-child {
        display: none;
    }

    #grc_eve_obj ul {
        display: none;
    }

    #grc_eveexc_desc img:last-child {
        display: none;
    }

    #grc_eveexc_obj ul {
        display: none;
    }


</style>




<?php
$tabela = 'grc_politica_vendas';
$id = 'idt';

$onSubmitDep = 'grc_politica_vendas_dep()';


$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro = "POLÍTICA DE VENDAS";

if ($acao == 'inc') {
    // Gerar Politica de Vendas em cadastramento
    $idt_politica_vendas = GerarPoliticaVendasInc();
    // trocar para alteração 
    $href = "conteudo.php?prefixo=cadastro&menu=grc_politica_vendas&acao=alt" . "&id=" . $idt_politica_vendas;
    $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
    echo $botao_acao;
}
$_SESSION[CS]['grc_politica_evento_condicao'] = $_GET['id'];

$js = " readonly=true style='background:#E0E0E0;' ";
$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45, $js);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');


$vetCampo['desconto_percentual'] = objDecimal('desconto_percentual', '% de Desconto?', True);





//

$vetStatusPV = Array();
$vetStatusPV['CA'] = 'Em Cadastramento';
$vetStatusPV['DI'] = 'Disponível';
$vetStatusPV['EX'] = 'Cancelada';
$vetCampo['status'] = objCmbVetor('status', 'Status', True, $vetStatusPV, '');


$maxlength = 4000;
$style = "width:100%;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Detalhada da Política de Venda', false, $maxlength, $style, $js);


if ($_GET['id'] == 0) {
    $_GET['id_usuario99'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 99);

$js = " readonly=true style='background:#E0E0E0;' ";

$vetCampo['data_responsavel'] = objTexto('data_responsavel', 'Data Registro', true, 30, 120, $js);


$vetCampo['data_inicio'] = objData('data_inicio', 'Data inicio validade', true, '', '', 'S');
$vetCampo['data_fim'] = objData('data_fim', 'Data fim validade', false, '', '', 'S');

// $sql = "select idt, codigo, descricao from plu_estado order by descricao";
// $vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
MesclarCol($vetCampo['detalhe'], 5);

MesclarCol($vetCampo['data_responsavel'], 3);
//MesclarCol($vetCampo['data_fim'], 3);

MesclarCol($vetCampo['desconto_percentual'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['data_inicio'], '', $vetCampo['data_fim'], '', $vetCampo['status']),
    Array($vetCampo['desconto_percentual']),
    Array($vetCampo['detalhe']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_responsavel']),
        ), $class_frame, $class_titulo, $titulo_na_linha);



$vetCad[] = $vetFrm;

$vetFrm = Array();
/*
  //
  // TABELAS
  //

  $vetParametros = Array(
  'codigo_frm' => 'tabelas',
  'controle_fecha' => 'A',
  );
  $vetFrm[] = Frame('TABELAS', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetCampo = Array();
  $vetCampo['codigo']    = CriaVetTabela('Código');
  $vetCampo['descricao'] = CriaVetTabela('Descrição');
  $vetCampo['alias'] = CriaVetTabela('Alias');
  //$vetCampo['data'] = CriaVetTabela('Data', 'data');
  //$vetCampo['plu_usu_nome_completo'] = CriaVetTabela('Responsável');
  //$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
  //$vetCampo['detalhe'] = CriaVetTabela('Detalhe');

  $titulo = 'Tabelas';

  $TabelaPrinc = "grc_politica_vendas_tabelas";
  $AliasPric   = "grc_pvt";
  $Entidade    = "Política de Vendas";
  $Entidade_p  = "Políticas de Vendas";

  $CampoPricPai = "idt_politica_vendas";

  $orderby = "{$AliasPric}.codigo";

  $sql = "select {$AliasPric}.* ";
  //$sql .= "       plu_usu.nome_completo as plu_usu_nome_completo ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  //$sql .= " inner join grc_produto grc_pp on grc_pp.idt = {$AliasPric}.idt_produto ";
  //$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = {$AliasPric}.idt_responsavel ";
  $sql .= " where {$AliasPric}" . '.idt_politica_vendas = $vlID';
  $sql .= " order by {$orderby}";

  $vetCampo['grc_politica_vendas_tabelas'] = objListarConf('grc_politica_vendas_tabelas', 'idt', $vetCampo, $sql, $titulo, false);

  $vetParametros = Array(
  'codigo_pai' => 'tabelas',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_politica_vendas_tabelas']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


  $vetCad[] = $vetFrm;

  //~ /////////////// campos

  $vetFrm = Array();

  //
  // CAMPOS
  //

  $vetParametros = Array(
  'codigo_frm' => 'campos',
  'controle_fecha' => 'A',
  );
  $vetFrm[] = Frame('CAMPOS', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

  $vetCampo = Array();
  $vetCampo['codigo']    = CriaVetTabela('Expressão/Código');
  $vetCampo['alias'] = CriaVetTabela('Alias');
  $vetCampo['descricao'] = CriaVetTabela('Descrição');
  $vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );


  $titulo = 'Campo';

  $TabelaPrinc = "grc_politica_vendas_campos";
  $AliasPric   = "grc_pvc";
  $Entidade    = "Campo da Política de Vendas";
  $Entidade_p  = "Campos da Política de Vendas";

  $CampoPricPai = "idt_politica_vendas";

  $orderby = "{$AliasPric}.codigo";

  $sql = "select {$AliasPric}.* ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  $sql .= " where {$AliasPric}" . '.idt_politica_vendas = $vlID';
  $sql .= " order by {$orderby}";

  $vetCampo['grc_politica_vendas_campos'] = objListarConf('grc_politica_vendas_campos', 'idt', $vetCampo, $sql, $titulo, false);

  $vetParametros = Array(
  'codigo_pai' => 'campos',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_politica_vendas_campos']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


  $vetCad[] = $vetFrm;
 */


/*
  $vetRetorno = Array(
  vetRetorno('idt_evento', 'idt_evento', false, true, true),
  //    vetRetorno('idt_natureza', 'idt_natureza', false, true, true),
  vetRetorno('codigo', '', true, false),
  vetRetorno('descricao', '', true, false),
  );
  $vetCampo['grc_eve'] = objListarCmbMulti('grc_eve', 'grc_politica_vendas', 'Escolha de Eventos para Compor a Política de Vendas', true, '', 'idt', '', $vetRetorno);
 */



$vetRetorno = Array(
    vetRetorno('idt_evento', '', false),
    vetRetorno('codigo', '', true),
    vetRetorno('descricao', '', true),
);
$vetCampo['grc_eve'] = objListarCmbMulti('grc_eve', 'grc_politica_vendas', 'Escolha de Eventos para Compor a Política de Vendas', false, '', '', '', $vetRetorno);




/*
  $vetFrm[] = Frame('<span>Escolha de Eventos para Política de Vendas</span>', Array(
  Array($vetCampo['grc_eve']),
  ), $class_frame, $class_titulo, $titulo_na_linha);

  $vetCad[] = $vetFrm;
 */


















///////////////// condicao PARA SELEÇÃO DE EVENTOS

$vetFrm = Array();

//
// CONDIÇÃO
//

$vetParametros = Array(
    'codigo_frm' => 'condicao',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('CONDIÇÃO PARA SELEÇÃO DE EVENTOS', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'condicao',
    'width' => '100%',
);

$vetCampo['grc_politica_vendas_condicao_evento'] = objInclude('grc_politica_vendas_condicao_evento', 'cadastro_conf/grc_politica_vendas_condicao_evento.php');
$vetCampo['grc_politica_vendas_condicao_evento_formula'] = objTextoFixoVL('grc_politica_vendas_condicao_evento_formula', 'Fórmula', '', '', false);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_politica_vendas_condicao_evento']),
    Array($vetCampo['grc_politica_vendas_condicao_evento_formula']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetCampo = Array();
  $vetCampo['ordem']    = CriaVetTabela('Ordem');
  $vetParenteseAnt=Array();
  $vetParenteseAnt['(']='(';
  $vetCampo['parentese_ant']     = CriaVetTabela('(', 'descDominio', $vetParenteseAnt );
  $vetCampo['codigo']    = CriaVetTabela('Expressão/Código');

  $vetCondicao=Array();
  $vetCondicao['=']='Igual a';
  $vetCondicao['<>']='Diferende de';
  $vetCondicao['>']='Maior do que';
  $vetCondicao['<']='Menor do que';
  $vetCondicao['>=']='Maior ou Idual a';
  $vetCondicao['<=']='Menor ou Igual a';
  $vetCondicao['like']='Contem';
  $vetCampo['condicao'] = CriaVetTabela('Condição', 'descDominio', $vetCondicao );

  $vetCampo['valor']    = CriaVetTabela('Valor');


  $vetParenteseDep=Array();
  $vetParenteseDep[')']=')';
  $vetCampo['parentese_dep']     = CriaVetTabela(')', 'descDominio', $vetParenteseDep );



  $vetOperador=Array();
  $vetOperador['e']=' e ';
  $vetOperador['ou']=' ou ';
  $vetCampo['operador']     = CriaVetTabela('e/ou', 'descDominio', $vetOperador );




  $titulo = 'Condição para Seleção de Eventos';

  $TabelaPrinc = "grc_politica_vendas_condicao";
  $AliasPric   = "grc_pvco";
  $Entidade    = "Condição da Política de Vendas";
  $Entidade_p  = "Candições da Política de Vendas";

  $CampoPricPai = "idt_politica_vendas";

  $orderby = "{$AliasPric}.ordem";

  $sql = "select {$AliasPric}.* ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  $sql .= " where {$AliasPric}" . '.idt_politica_vendas = $vlID';
  $sql .= "   and {$AliasPric}" . '.tipo = '.aspa('P');
  $sql .= " order by {$orderby}";

  $vetCampo['grc_politica_vendas_condicao'] = objListarConf('grc_politica_vendas_condicao', 'idt', $vetCampo, $sql, $titulo, false);

  $vetParametros = Array(
  'codigo_pai' => 'condicao',
  'width' => '100%',
  );

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_politica_vendas_condicao']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 */


$vetCad[] = $vetFrm;






//~ /////////////// eventos


/*
  $vetRetorno = Array(
  vetRetorno('idt_evento', 'idt_evento', false, true, true),
  //    vetRetorno('idt_natureza', 'idt_natureza', false, true, true),
  vetRetorno('codigo', '', true, false),
  vetRetorno('descricao', '', true, false),
  );
  $vetCampo['grc_eve'] = objListarCmbMulti('grc_eve', 'grc_politica_vendas', 'Escolha de Eventos para Compor a Política de Vendas', true, '', 'idt', '', $vetRetorno);
 */

$vetRetorno = Array(
    vetRetorno('idt', '', false),
    vetRetorno('codigo', '', true),
    vetRetorno('descricao', '', true),
);
$vetCampo['grc_eve'] = objListarCmbMulti('grc_eve', 'grc_politica_vendas', 'Escolha de Eventos para Compor a Política de Vendas', false, '', '', '', $vetRetorno);

$vetRetorno = Array(
    vetRetorno('idt', '', false),
    vetRetorno('codigo', '', true),
    vetRetorno('descricao', '', true),
);
$vetCampo['grc_eveexc'] = objListarCmbMulti('grc_eveexc', 'grc_politica_vendas_exc', "Escolha de Eventos para EXCLUSÃO da Política de Vendas", false, '', '', '', $vetRetorno);



$vetFrm = Array();

//
// EVENTOS
//

$vetParametros = Array(
    'codigo_frm' => 'eventos',
    'controle_fecha' => 'A',
    'barra_inc_ap' => false,
    'barra_alt_ap' => false,
    'barra_con_ap' => false,
    'barra_exc_ap' => true,
);
$vetFrm[] = Frame('EVENTOS DA POLÍTICA DE VENDAS', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_eve'], '', $vetCampo['grc_eveexc']),
        ), $class_frame, $class_titulo, $titulo_na_linha);




$vetCampo = Array();
$vetCampo['grc_e_codigo'] = CriaVetTabela('Código');
$vetCampo['grc_e_descricao'] = CriaVetTabela('Descrição');

$titulo = 'Eventos';

$TabelaPrinc = "grc_politica_vendas_eventos";
$AliasPric = "grc_pve";
$Entidade = "Evento da Política de Vendas";
$Entidade_p = "Eventos da Política de Vendas";

$CampoPricPai = "idt_politica_vendas";

$orderby = "grc_e.codigo";

$sql = "select {$AliasPric}.*, ";
$sql .= "        grc_e.codigo    as grc_e_codigo, ";
$sql .= "        grc_e.descricao as grc_e_descricao ";
$sql .= " from {$TabelaPrinc} {$AliasPric}  ";
$sql .= " inner join grc_evento grc_e on grc_e.idt = {$AliasPric}.idt_evento  ";
$sql .= " where {$AliasPric}" . '.idt_politica_vendas = $vlID';
$sql .= " order by {$orderby}";

$vetCampo['grc_politica_vendas_eventos'] = objListarConf('grc_politica_vendas_eventos', 'idt', $vetCampo, $sql, $titulo, false, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'eventos',
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_politica_vendas_eventos']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;



///////////////// condicao PARA SELEÇÃO NA MATRÍCULA

$vetFrm = Array();

//
// CONDIÇÃO DA MATRÍCULA
//

$vetParametros = Array(
    'codigo_frm' => 'condicao_matricula',
    'controle_fecha' => 'A',
);
$vetFrm[] = Frame('CONDIÇÃO PARA SELEÇÃO NA MATRÍCULA', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'condicao_matricula',
    'width' => '100%',
);

$vetCampo['grc_politica_vendas_condicao_matricula'] = objInclude('grc_politica_vendas_condicao_matricula', 'cadastro_conf/grc_politica_vendas_condicao_matricula.php');
$vetCampo['grc_politica_vendas_condicao_matricula_formula'] = objTextoFixoVL('grc_politica_vendas_condicao_matricula_formula', 'Fórmula', '', '', false);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['grc_politica_vendas_condicao_matricula']),
    Array($vetCampo['grc_politica_vendas_condicao_matricula_formula']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

/*
  $vetCampo = Array();
  $vetCampo['ordem']    = CriaVetTabela('Ordem');
  $vetParenteseAnt=Array();
  $vetParenteseAnt['(']='(';
  $vetCampo['parentese_ant']     = CriaVetTabela('(', 'descDominio', $vetParenteseAnt );
  $vetCampo['codigo']    = CriaVetTabela('Expressão/Código');

  $vetCondicao=Array();
  $vetCondicao['=']='Igual a';
  $vetCondicao['<>']='Diferende de';
  $vetCondicao['>']='Maior do que';
  $vetCondicao['<']='Menor do que';
  $vetCondicao['>=']='Maior ou Idual a';
  $vetCondicao['<=']='Menor ou Igual a';
  $vetCondicao['like']='Contem';
  $vetCampo['condicao']     = CriaVetTabela('Condição', 'descDominio', $$vetCondicao );

  $vetCampo['valor']    = CriaVetTabela('Valor');


  $vetParenteseDep=Array();
  $vetParenteseDep[')']=')';
  $vetCampo['parentese_dep']     = CriaVetTabela(')', 'descDominio', $vetParenteseDep );



  $vetOperador=Array();
  $vetOperador['e']=' e ';
  $vetOperador['ou']=' ou ';
  $vetCampo['operador']     = CriaVetTabela('e/ou', 'descDominio', $vetOperador );




  $titulo = 'Condição para Matrícula';

  $TabelaPrinc = "grc_politica_vendas_condicao";
  $AliasPric   = "grc_pvco";
  $Entidade    = "Condição da Política de Vendas";
  $Entidade_p  = "Candições da Política de Vendas";

  $CampoPricPai = "idt_politica_vendas";

  $orderby = "{$AliasPric}.ordem";

  $sql = "select {$AliasPric}.* ";
  $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
  $sql .= " where {$AliasPric}" . '.idt_politica_vendas = $vlID';
  $sql .= "   and {$AliasPric}" . '.tipo = '.aspa('M');
  $sql .= " order by {$orderby}";

  $vetCampo['grc_politica_vendas_condicao_matricula'] = objListarConf('grc_politica_vendas_condicao_matricula', 'idt', $vetCampo, $sql, $titulo, false);

  $vetFrm[] = Frame('', Array(
  Array($vetCampo['grc_politica_vendas_condicao_matricula']),
  ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);
 * 
 */

$vetCad[] = $vetFrm;


/*
  $vetTab = Array(
  //    1 => 'Tabelas',
  //	2 => 'Campos Seleção',
  3 => 'Condição',
  );

  $vetTab = Array(
  1 => 'Eventos',
  2 => 'Condição',
  );
 */
?>
<script>

    function parListarCmbMulti_grc_eve() {
        if (wizardValidaCadastro('wizardEvento') === false) {
            return false;
        } else {
            var ok = '';

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grava_grc_politica_vendas_condicao_evento',
                data: {
                    cas: conteudo_abrir_sistema,
                    form: $('#frm').serialize()
                },
                success: function (response) {
                    if (response.erro != '') {
                        ok = false;
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    ok = false;
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            return ok;
        }
    }


    function fncListarCmbMultiMuda_grc_eve(session_cod) {
        //alert('só alegria');
        //return false;
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_eve',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: session_cod,
                idt_politica_venda: $('#id').val()
            },
            success: function (response) {
                btFechaCTC($('#grc_politica_vendas_eventos').data('session_cod'));
                //alert('só alegria');
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

    function fncListarCmbMultiMuda_grc_eveexc(session_cod) {
        //alert('só alegria');
        //return false;
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=grc_eveexc',
            data: {
                cas: conteudo_abrir_sistema,
                session_cod: session_cod,
                idt_politica_venda: $('#id').val()
            },
            success: function (response) {
                btFechaCTC($('#grc_politica_vendas_eventos').data('session_cod'));
                //alert('só alegria');
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

    function grc_politica_vendas_dep() {
        ok = true;
        
        if (ok) {
            ok = wizardValidaCadastro('wizardEvento');
        }
        
        if (ok) {
            ok = wizardValidaCadastro('wizardMatricula');
        }
        
        return ok;
    }
</script>