<?php
$tabela = 'grc_atendimento_usuario_disponibilidade';
$id = 'idt';

$TabelaPai   = "db_pir_grc.plu_usuario";
$AliasPai    = "grc_pu";
$EntidadePai = "Consultore/Atendente";
$idPai       = "id_usuario";

$CampoPricPai     = "idt_usuario";

/*

if ($acao=='inc')
{
     $idt_ponto_atendimento = $_SESSION[CS]['g_idt_unidade_regional'];
     $idt_usuario           = $CampoPricPai;

     $sql  = "select  ";
     $sql .= " grc_pp.*  ";
     $sql .= " from grc_atendimento_pa_pessoa grc_pp ";
     $sql .= " where idt_ponto_atendimento = ".null($idt_ponto_atendimento) ;
     $sql .= "   and idt_usuario           = ".null($_SESSION[CS]['g_id_usuario']) ;
     
     $rs = execsql($sql);
     $duracao = 11;
     ForEach($rs->data as $row)
     {
         $duracao = $row['duracao'];
     }
     $vetCampo['duracao'] = objTextoFixoVL('duracao', 'Duração', $duracao, 10, True);
}
else
{
    $vetCampo['duracao']    = objInteiro('duracao', 'Duração (min)', True, 5, 5);
}

*/

echo "<br /> ";
echo "<br /> ";
echo "<br /> ";
echo "<br /> ";
echo "<br /> ";
echo "<br /> ";




//$onSubmitCon = ' grc_atendimento_usuario_disponibilidade_con() ';

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'id_usuario', 'nome_completo', 0);




// $vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', ''.db_pir.'sca_organizacao_secao', 'idt', 'descricao', 1);



$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql .= ' order by classificacao ';
if ($acao =='inc')
{
    $js = " ";
}
else
{
    $js    = " disabled style='background:#FFFFD7; font-size:14px;' ";
}
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', true, $sql, ' ', ' width:45%; font-size:12px;', $js);


$js    = " readonly='true' style='width:30px; background:#FFFF80; font-size:14px;' ";

$vetCampo['dia']   = objCmbVetor('dia', 'Dia da Semana', True, $vetDiaSemana);

$vetCampo['num_dia'] = objHidden('num_dia', '', '', '', false);

$js_hm   = "";
$vetCampo['hora_inicial'] = objHora('hora_inicial', 'Hora Inicial', True,$js_hm);
$vetCampo['hora_final']   = objHora('hora_final', 'Hora Final', True,$js_hm);
$vetCampo['duracao']      = objInteiro('duracao', 'Duração (min)', True, 5, 5);
$vetCampo['ativo']        = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);
$vetFrm = Array();

MesclarCol($vetCampo[$CampoPricPai], 5);
MesclarCol($vetCampo['idt_ponto_atendimento'], 5);
MesclarCol($vetCampo['detalhe'], 11);
$vetFrm[] = Frame('<span>Consultor</span>', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['idt_ponto_atendimento']),
    Array($vetCampo['dia'],'',$vetCampo['num_dia'],'',$vetCampo['hora_inicial'],'',$vetCampo['hora_final'],'',$vetCampo['duracao'],'',$vetCampo['ativo']),
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>

<script type="text/javascript">

    var acao= ' <?php echo $acao; ?>' ;

    function grc_atendimento_usuario_disponibilidade_con()
    {

        var ret = true;

        var idt = '0';
        var id='idt';
        obj = document.getElementById(id);
        if (obj != null) {
           idt = obj.value;
        }
        var idt_usuario = '0';
        var id='idt_usuario';
        obj = document.getElementById(id);
        if (obj != null) {
           idt_usuario = obj.value;
        }
        var dia = '';
        var id='dia';
        obj = document.getElementById(id);
        if (obj != null) {
           dia = obj.value;
        }
        var hora_inicial = '';
        var id='hora_inicial';
        obj = document.getElementById(id);
        if (obj != null) {
           hora_inicial = obj.value;
        }
        var hora_final = '';
        var id='hora_final';
        obj = document.getElementById(id);
        if (obj != null) {
           hora_final = obj.value;
        }

//      alert('acao= '+ acao+' idt ='+idt+' idt_usuario ='+idt_usuario+' dia = '+dia+'hora_inicial = '+hora_inicial+' hora_final = '+hora_final);


        var str = '';
        
        $.post('ajax_atendimento.php?tipo=ConsisteHoras',
        {
                async : false,
                acao        : acao,
                idt         : idt,
                idt_usuario : idt_usuario,
                dia         : dia,
                hora_inicial: hora_inicial,
                hora_final  : hora_final
        }
    , function (str) {
        if (str == '')
        {
//            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
        else
        {

           alert(url_decode(str).replace(/<br>/gi, "\n"));


            var ret = str.split('###');
            ret = ret[0];
            mensagem = ret[1];
//          var id='data_confirmacao';
//          obj = document.getElementById(id);
//          if (obj != null) {
//              obj.value = data;
//          }
//          var id='hora_confirmacao';
//          obj = document.getElementById(id);
//          if (obj != null) {
//              obj.value = hora;
//           }
             if  (ret == 1)
             {
//               alert('Agendamento Confirmado');
             }
             else
             {
                alert('mensagem = '+mensagem);
             }
         }
    });

    return ret;
    }
</script>