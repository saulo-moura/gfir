<style type="text/css">
    #filtro select {
        width: 450px;
    }
</style>
<?php
$ordFiltro = false;
$idCampo = 'idt';
$Tela = "o Grupo de Atendimento do NAN";

$TabelaPrinc = "grc_nan_grupo_atendimento";
$AliasPric = "grc_nga";
$Entidade = "O Grupo de atendimento do NAN";
$Entidade_p = "Os Grupos de atendimento do NAN";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$barra_inc_ap = false;
$barra_alt_ap = false;
$barra_exc_ap = false;
$barra_con_ap = true;


$tipoidentificacao = 'N';
$tipofiltro = 'S';

$comfiltro = 'A';
$comidentificacao = 'F';

echo "<div style='width:100%; text-align:center; font-weight:bold; display:block; background:#2F66B8; color:#FFFFFF; font-size:18px; '>";

$veio = $_GET['veio'];
if ($veio == 'D') {
    echo "DIAGNÓSTICO SITUACIONAL";
    $barra_con_img = "imagens/consultar_diagnostico.png";
}

if ($veio == 'DE') {
    echo "DEVOLUTIVA";
    $barra_con_img = "imagens/consultar_devolutiva.png";
}
echo "</div>";

$sql = '';
$sql .= ' select ne.idt, ne.idt_ponto_atendimento, ne.idt_nan_tipo';
$sql .= ' from grc_nan_estrutura ne';
$sql .= ' inner join grc_nan_estrutura_tipo net on net.idt = ne.idt_nan_tipo';
$sql .= ' where ne.idt_usuario = '.null($_SESSION[CS]['g_id_usuario']);
$sql .= ' order by net.ordem limit 1';
$rs = execsql($sql);
$row = $rs->data[0];

if (acesso($menu, "'PER'", false)) {
    $tudo = true;
} else {
    $tudo = false;
}

$vetNE = Array();
$vetNE[0] = 0;

if ($row['idt'] != '') {
    $vetNE[$row['idt']] = $row['idt'];
}

$vetTutor = Array();
$vetTutor[0] = 0;

$vetAOE = Array();
$vetAOE[0] = 0;

switch ($row['idt_nan_tipo']) {
    case 8: //Diretor
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 8';
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 9: //Gerente Estadual
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 9';
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 2: //Gestor Estadual
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 2';
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 4: //Tutor Sênior
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 4';
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 10: //Gerente Regional
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 10';

        if ($row['idt_ponto_atendimento'] != 6) {
            $sql .= ' and idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
        }

        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 3: //Gestor Local
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 3';

        if ($row['idt_ponto_atendimento'] != 6) {
            $sql .= ' and idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
        }

        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
        }

    case 5: //Tutor
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' and idt_nan_tipo = 5';

        if ($row['idt_ponto_atendimento'] != 6) {
            $sql .= ' and idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
        }

        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetNE[$rowt['idt']] = $rowt['idt'];
            $vetTutor[$rowt['idt']] = $rowt['idt'];
        }

    default: //OAE
        $sql = '';
        $sql .= ' select idt_usuario';
        $sql .= ' from grc_nan_estrutura';
        $sql .= ' where (idt_tutor in ('.implode(', ', $vetNE).')';
        $sql .= ' or idt = '.null($row['idt']).')';
        $sql .= ' and idt_nan_tipo = 6';

        if ($row['idt_ponto_atendimento'] != 6) {
            $sql .= ' and idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
        }

        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetAOE[$rowt['idt_usuario']] = $rowt['idt_usuario'];
        }
        break;
}

$Filtro = Array();
$sql = 'select idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao ';
$sql .= " where tipo_estrutura = 'UR' ";

if (!$tudo) {
    if ($row['idt_ponto_atendimento'] != 6) {
        $sql .= ' and idt = '.null($row['idt_ponto_atendimento']);
    }
}

$sql .= ' order by descricao ';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'filtro_unidade';
$Filtro['id_select'] = 'idt';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Unidade';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_unidade'] = $Filtro;

$sql = '';
$sql .= ' select distinct u.id_usuario, u.nome_completo';
$sql .= ' from grc_nan_estrutura e';
$sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
$sql .= ' where e.idt_nan_tipo = 5';

if (!$tudo) {
    $sql .= ' and e.idt in ('.implode(', ', $vetTutor).')';

    if ($row['idt_ponto_atendimento'] != 6) {
        $sql .= ' and e.idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
    }
}

$sql .= ' order by u.nome_completo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'filtro_tutor';
$Filtro['nome'] = 'Tutor';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_tutor'] = $Filtro;

$sql = '';
$sql .= ' select distinct u.id_usuario, u.nome_completo';
$sql .= ' from grc_nan_estrutura e';
$sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
$sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
$sql .= ' where e.idt_nan_tipo = 6';

if (!$tudo) {
    $sql .= ' and e.idt_usuario in ('.implode(', ', $vetAOE).')';

    if ($row['idt_ponto_atendimento'] != 6) {
        $sql .= ' and e.idt_ponto_atendimento = '.null($row['idt_ponto_atendimento']);
    }
}

$sql .= ' order by u.nome_completo';
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'filtro_consultor';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'AOE';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_consultor'] = $Filtro;

$sql = "select distinct id_usuario, nome_completo from plu_usuario plu_usu ";
$sql .= " inner join grc_atendimento grc_at on grc_at.idt_nan_empresa = plu_usu.id_usuario ";
$sql .= " where idt_grupo_atendimento is not null ";

if (!$tudo) {
    $sql .= ' and grc_at.idt_consultor_prox_atend in ('.implode(', ', $vetAOE).')';
}

$sql .= " order by nome_completo";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id_select'] = 'id_usuario';
$Filtro['id'] = 'filtro_empresa';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Empresa Executora';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_empresa'] = $Filtro;

$sql = "select distinct gec_eo.idt,  gec_eo.descricao from grc_nan_grupo_atendimento grc_gat";
$sql .= " inner join ".db_pir_gec."gec_entidade gec_eo on gec_eo.idt = grc_gat.idt_organizacao ";
$sql .= " order by descricao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'filtro_cliente';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Razão Social';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_cliente'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['filtro_texto'] = $Filtro;


$vetpasso = Array();
$vetpasso[1] = "1a Visita";
$vetpasso[2] = "2a Visita";
$vetpasso[3] = "3a Visita";

$vetCampo['num_visita_atu'] = CriaVetTabela('Passo<br />Atual', 'descDominio', $vetpasso);
$vetCampo['grc_at_protocolo'] = CriaVetTabela('Protocolo<br />1a Visita');
$vetCampo['grc_at_data'] = CriaVetTabela('Data<br />1a Visita', 'data');
$vetCampo['gec_eo_descricao'] = CriaVetTabela('Razão Social');
$vetCampo['grc_ap_nome'] = CriaVetTabela('Representante<br />1a Visita');
$vetCampo['plu_usuc_nome_completo'] = CriaVetTabela('AOE');
$vetCampo['plu_usue_nome_completo'] = CriaVetTabela('Empresa Executora');
$vetCampo['data_aprovador_1'] = CriaVetTabela('Aprovação<br />1a Visita', 'data');

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= "   grc_at.data as grc_at_data,  ";
$sql .= "   grc_at.protocolo as grc_at_protocolo,  ";
$sql .= "   plu_usuc.nome_completo as plu_usuc_nome_completo,  ";
$sql .= "   plu_usut.nome_completo as plu_usut_nome_completo,  ";
$sql .= "   plu_usue.nome_completo as plu_usue_nome_completo,  ";
$sql .= "   plu_usap.nome_completo as plu_usap_nome_completo,  ";
$sql .= "   gec_eo.descricao as gec_eo_descricao,  ";
$sql .= "   grc_ap.nome as grc_ap_nome  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_atendimento grc_at on grc_at.idt_grupo_atendimento = {$AliasPric}.idt";
$sql .= " inner join ".db_pir_gec."gec_entidade gec_eo on gec_eo.idt = {$AliasPric}.idt_organizacao";
$sql .= " inner join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_at.idt and grc_ap.tipo_relacao = 'L'";
$sql .= " left  join plu_usuario plu_usuc on plu_usuc.id_usuario = grc_at.idt_consultor";
$sql .= " left  join plu_usuario plu_usut on plu_usut.id_usuario = grc_at.idt_nan_tutor";
$sql .= " left  join plu_usuario plu_usue on plu_usue.id_usuario = grc_at.idt_nan_empresa";
$sql .= " left  join plu_usuario plu_usap on plu_usap.id_usuario = {$AliasPric}.idt_aprovador_1";
$sql .= " left  join grc_atendimento v2 on v2.idt_grupo_atendimento = grc_at.idt_grupo_atendimento and v2.nan_num_visita = 2";



$sql .= " where {$AliasPric}.status_1 = 'AP'";
$sql .= " and grc_at.nan_num_visita = 1";

if (!$tudo) {
    $sql .= ' and (grc_at.idt_consultor_prox_atend in ('.implode(', ', $vetAOE).') or v2.idt_consultor_prox_atend in ('.implode(', ', $vetAOE).'))';
}

if ($vetFiltro['filtro_unidade']['valor'] != "" && $vetFiltro['filtro_unidade']['valor'] != "0" && $vetFiltro['filtro_unidade']['valor'] != "-1") {
    $sql .= ' and grc_at.idt_unidade = '.null($vetFiltro['filtro_unidade']['valor']);
}

if ($vetFiltro['filtro_tutor']['valor'] != "" && $vetFiltro['filtro_tutor']['valor'] != "0" && $vetFiltro['filtro_tutor']['valor'] != "-1") {
    $sql .= ' and grc_at.idt_nan_tutor = '.null($vetFiltro['filtro_tutor']['valor']);
}

if ($vetFiltro['filtro_consultor']['valor'] != "" && $vetFiltro['filtro_consultor']['valor'] != "0" && $vetFiltro['filtro_consultor']['valor'] != "-1") {
    $sql .= ' and (grc_at.idt_consultor_prox_atend = '.null($vetFiltro['filtro_consultor']['valor']).' or v2.idt_consultor_prox_atend = '.null($vetFiltro['filtro_consultor']['valor']).')';
}

if ($vetFiltro['filtro_empresa']['valor'] != "" and $vetFiltro['filtro_empresa']['valor'] != "-1") {
    $sql .= " and grc_at.idt_nan_empresa = ".null($vetFiltro['filtro_empresa']['valor']);
}

if ($vetFiltro['filtro_cliente']['valor'] != "" and $vetFiltro['filtro_cliente']['valor'] != "-1") {
    $sql .= " and {$AliasPric}.idt_organizacao = ".null($vetFiltro['filtro_cliente']['valor']);
}

if ($vetFiltro['filtro_texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(grc_at.protocolo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usuc.nome_completo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usut.nome_completo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(plu_usue.nome_completo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_eo.descricao) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(gec_eo.codigo) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' or lower(grc_ap.nome) like lower('.aspa($vetFiltro['filtro_texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        /*
         $("#filtro_tutor").cascade("#filtro_unidade", {
         ajax: {
         url: ajax_sistema + '?tipo=nan_registro_pa&nan_tipo=5&cas=' + conteudo_abrir_sistema
         }
         });
         
         $("#filtro_consultor").cascade("#filtro_tutor", {
         ajax: {
         url: ajax_sistema + '?tipo=nan_registro_tutor&nan_tipo=6&cas=' + conteudo_abrir_sistema
         }
         });
         */
    });
</script>