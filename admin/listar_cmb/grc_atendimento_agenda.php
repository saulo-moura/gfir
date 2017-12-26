<?php
$tabela = 'grc_atendimento_agenda';
$id = 'idt';

$idt_atendimento_agenda = $_GET['id'];
$idt_cliente            = 0;


if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_aa.*  ";
     $sql .= " from grc_atendimento_agenda grc_aa ";
     $sql .= " where idt = {$idt_atendimento_agenda} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $situacao    = $row['situacao'];
         $origem      = $row['origem'];
         $idt_cliente = $row['idt_cliente'];
     }
     if ($situacao=='Cancelado' or $situacao=='Bloqueado')
     {
         $acao='con';
     }
}
else
{




}


$deondeveio = $_GET['deondeveio'];
echo " ----- $deondeveio ====== $idt_cliente ";
if ($deondeveio=="")
{
    $deondeveio="";
}
//
// "MA" --- Marcação ;
//
if ($origem=="Hora Marcada")
{
    $js      = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
    $js_hm   = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
}
else
{
    $js    = " onclick='return DiaSemana_t(this);' style=' font-size:14px;' ";
    $js_hm   = "";
}
$vetCampo['data'] = objData('data', 'Data Agenda', True,$js,'','S');

$vetCampo['hora'] = objHora('hora', 'Hora', True,$js_hm);



//
// $vetCampo['hora'] = objCmbVetor('hora', 'Hora', false, $vetHora,' ',$js_hm);
//
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['observacao_chegada'] = objTexto('observacao_chegada', 'Observação Chegada', false, 30, 120,$js);
$vetCampo['observacao_atendimento'] = objTexto('observacao_atendimento', 'Observação Atendimento', false, 30, 120,$js);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_confirmacao']   = objData('data_confirmacao', 'Data Confirmação', False, $js);

$vetCampo['hora_confirmacao'] = objTexto('hora_confirmacao', 'Hora Confirmação', False, 5, 5, $js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['hora_chegada'] = objTexto('hora_chegada', 'Hora Chegada', False, 5, 5,$js);
$vetCampo['hora_atendimento'] = objTexto('hora_atendimento', 'Hora Atendimento', False, 5, 5,$js);
$vetCampo['hora_liberacao'] = objTexto('hora_liberacao', 'Hora Liberação', False, 5, 5,$js);

$js    = "   readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['dia_semana'] = objTexto('dia_semana', 'Dia Semana', false, 3, 3,$js);
//$vetCampo['telefone'] = objTexto('telefone', 'Telefone', False, 15, 15);
//$vetCampo['celular'] = objTexto('celular', 'Celular', False, 15, 15);
$vetCampo['origem'] = objTexto('origem', 'Origem', False,15,15,$js);



$js=" style='width:140px; ' ";
$js="  ";
$vetCampo['telefone']         = objTelefone('telefone', 'Telefone de Contato', false, $js);
$vetCampo['celular']          = objTelefone('celular', 'Celular de Contato', false, $js);
$vetCampo['email']            = objEmail('email', 'Email de Contato', false, 35, 120,'S');


//$sql  = "select idt, descricao from grc_atendimento_situacao_agenda ";
//$sql .= " order by descricao";
//$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', false, $sql,' ','width:100px;');

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['situacao'] = objTexto('situacao', 'Situação', false, 10, 20,$js);




if ($origem=="Hora Marcada")
{
    $js_hm   = " disabled  ";
    $style   = 'background:#FFFF80; font-size:14px; width:200px;';
    
}
else
{
    $js_hm   = "";
    $style   = ' width:200px;';
}
$sql  = "select idt, descricao from grc_atendimento_especialidade ";
$sql .= " order by descricao";
$vetCampo['idt_especialidade'] = objCmbBanco('idt_especialidade', 'Especialidade', false, $sql,' ',$style,$js_hm);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_consultor'] = objCmbBanco('idt_consultor', 'Consultor/Atendente', false, $sql,' ',$style,$js_hm);

$maxlength  = 2000;
$style      = "width:830px; ";
$js         = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', false, $maxlength, $style, $js);


//$sql  = "select idt, descricao from ".db_pir_gec."gec_entidade ";
//$sql .= " order by descricao";
//$vetCampo['idt_cliente'] = objCmbBanco('idt_cliente', 'Cliente', false, $sql,' ','width:400px;');

if ($idt_cliente>0)
{
    $jst    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

}
else
{
    $jst="  ChamaCPFEspecial(this)  ";
}
$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', false,true,'',$jst);

$vetCampo['cliente_texto']    = objTexto('cliente_texto', 'Cliente', false, 40, 120);

if ($origem=="Hora Marcada")
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', false,'300px');
}
else
{
    $vetCampo['idt_cliente']      = objListarCmb('idt_cliente', 'gec_entidade_agenda_cmb', 'Cliente', true,'300px');
}

$vetCampo['cnpj']             = objCNPJ('cnpj', 'CNPJ da Empresa', false);
$vetCampo['nome_empresa']             = objTexto('nome_empresa', 'Nome completo da Empresa', false, 40, 120);




$sql  = "select idt, descricao from ".db_pir."sca_organizacao_secao ";
$sql .= " order by descricao";
$js = " disabled ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto Atendimento', true, $sql,' ','background:#FFFF80; width:250px;',$js);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);
$vetCampo['confirmacao_chegada'] = objInclude('confirmacao_chegada', 'cadastro_conf/confirmacao_chegada.php');
$vetCampo['confirmacao_liberacao'] = objInclude('confirmacao_liberacao', 'cadastro_conf/confirmacao_liberacao.php');
$vetCampo['chama_atendimento'] = objInclude('chama_atendimento', 'cadastro_conf/chama_atendimento.php');
$vetCampo['confirmacao_atendimento'] = objInclude('confirmacao_atendimento', 'cadastro_conf/confirmacao_atendimento.php');
//$vetCampo['confirmacao_agendamento'] = objInclude('confirmacao_agendamento', 'cadastro_conf/confirmacao_agendamento.php');
$vetCampo['confirmacao_agendamento_desconfirma']  = objInclude('confirmacao_agendamento_desconfirma', 'cadastro_conf/confirmacao_agendamento_desconfirma.php');
$vetCampo['confirmacao_agendamento_bloqueio']     = objInclude('confirmacao_agendamento_bloqueio', 'cadastro_conf/confirmacao_agendamento_bloqueio.php');
$vetCampo['confirmacao_agendamento_cancelamento'] = objInclude('confirmacao_agendamento_cancelamento', 'cadastro_conf/confirmacao_agendamento_cancelamento.php');
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$js         = " visibility='hidden' ";
$vetCampo['tipo_pessoa']      = objCmbVetor('tipo_pessoa', 'Prioridade?', false, $vetSimNao,' ',$js);
$maxlength  = 2000;
$style      = "width:700px;  background:#FFFF80; font-size:14px;";
$js         = " readonly='true' ";
$vetCampo['mensagem'] = objTextArea('mensagem', 'Forma de atendimento na Fila', false, $maxlength, $style, $js);
$vetCampo['botao_atendimento_agenda_prioridade_sim'] = objInclude('botao_atendimento_agenda_prioridade_sim', 'cadastro_conf/botao_atendimento_agenda_prioridade_sim.php');
$vetCampo['botao_atendimento_agenda_prioridade_nao'] = objInclude('botao_atendimento_agenda_prioridade_nao', 'cadastro_conf/botao_atendimento_agenda_prioridade_nao.php');
$vetCampo['botao_hora_marcada_agenda'] = objInclude('botao_hora_marcada_agenda', 'cadastro_conf/botao_hora_marcada_agenda.php');
$vetCampo['botao_hora_extra_agenda']   = objInclude('botao_hora_extra_agenda', 'cadastro_conf/botao_hora_extra_agenda.php');
$js         = " visibility='hidden' ";

$vetCampo['hora_marcada_extra']      = objCmbVetor('hora_marcada_extra', 'Hora Marcada?', false, $vetSimNao,' ',$js);


//$vetCampo['protocolo']        = objAutonum('protocolo', 'Senha',15,true);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['protocolo']        = objTexto('protocolo', 'Protocolo de Marcação',false,15,45,$js);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_hora_marcacao'] = objDatahora('data_hora_marcacao', 'Data Marcação', False,$js);

$vetFrm = Array();

//MesclarCol($vetCampo['confirmacao_agendamento_bloqueio'], 7);
MesclarCol($vetCampo['confirmacao_agendamento_bloqueio'], 3);
$vetFrm[] = Frame('<span>Dados do Agendamento</span>', Array(
    Array($vetCampo['data'],'',$vetCampo['hora'],'',$vetCampo['dia_semana'],' ',$vetCampo['idt_ponto_atendimento']),
    Array($vetCampo['idt_consultor'],'',$vetCampo['idt_especialidade'],'',$vetCampo['origem'],'',$vetCampo['situacao']),
    Array($vetCampo['confirmacao_agendamento_bloqueio']),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_cliente'], 3);
//MesclarCol($vetCampo['idt_especialidade'], 3);
MesclarCol($vetCampo['assunto'], 5);

//MesclarCol($vetCampo['idt_cliente'], 3);
MesclarCol($vetCampo['nome_empresa'], 3);
MesclarCol($vetCampo['cliente_texto'], 3);
//MesclarCol($vetCampo['celular'], 3);
$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['cpf'],'', $vetCampo['idt_cliente'],'', $vetCampo['cliente_texto']),
   // Array('' ,'', $vetCampo['cliente_texto']),
    Array($vetCampo['cnpj'],'', $vetCampo['nome_empresa']),
    Array($vetCampo['telefone'],'',$vetCampo['celular'],$vetCampo['email'],''),
    Array($vetCampo['assunto']),

 ),$class_frame,$class_titulo,$titulo_na_linha);


MesclarCol($vetCampo['assunto'], 3);
MesclarCol($vetCampo['tipo_pessoa'], 3);

MesclarCol($vetCampo['mensagem'], 3);


$vetFrm[] = Frame("<span>{$titulo_cadastro}</span>", Array(
    Array($vetCampo['protocolo'],'',$vetCampo['data_hora_marcacao'],'',$vetCampo['confirmacao_agendamento_cancelamento']),
    Array($vetCampo['botao_hora_marcada_agenda'],'',$vetCampo['botao_hora_extra_agenda']),
    Array($vetCampo['botao_atendimento_agenda_prioridade_sim'],'',$vetCampo['botao_atendimento_agenda_prioridade_nao']),
    Array($vetCampo['hora_marcada_extra']),
    Array($vetCampo['mensagem']),
    Array($vetCampo['tipo_pessoa']),
),$class_frame,$class_titulo,$titulo_na_linha);









MesclarCol($vetCampo['confirmacao_agendamento'], 3);
$vetFrm[] = Frame('<span>Confirmação da Marcação</span>', Array(
    Array($vetCampo['data_confirmacao'],'',$vetCampo['hora_confirmacao'],'',$vetCampo['confirmacao_agendamento_desconfirma']),

),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['confirmacao_chegada'], 5);
$vetFrm[] = Frame('<span>Registro da Chegada</span>', Array(
    Array($vetCampo['confirmacao_chegada'],'',$vetCampo['hora_chegada'],' ',$vetCampo['observacao_chegada'],'',$vetCampo['hora_liberacao'],'',$vetCampo['confirmacao_liberacao']),
    //Array($vetCampo['confirmacao_chegada']),
    //Array($vetCampo['confirmacao_liberacao']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetFrm[] = Frame('<span> Chamar Cliente para Atendimento</span>', Array(
    Array($vetCampo['chama_atendimento']),

),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['confirmacao_atendimento'], 3);
$vetFrm[] = Frame('<span>Registro do Atendimento</span>', Array(
    Array($vetCampo['hora_atendimento'],'',$vetCampo['observacao_atendimento'],'',$vetCampo['confirmacao_atendimento']),
),$class_frame,$class_titulo,$titulo_na_linha);





$vetFrm[] = Frame('<span>Observações Gerais</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);







$vetCad[] = $vetFrm;
?>
<script>
var idt_atendimento_agenda =  '<?php echo  $idt_atendimento_agenda; ?>' ;
var idt_cliente            =  '<?php echo  $idt_cliente; ?>' ;
var veio                   =  '<?php echo  $deondeveio; ?>' ;
var origem                 =  '<?php echo  $origem; ?>' ;
$(document).ready(function () {
    if (veio=='MA')
    {
           objd=document.getElementById('frm3');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm3');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
           objd=document.getElementById('frm4');
           if (objd != null)
           {
               $(objd).css('display','none');
           }

           objd=document.getElementById('frm5');
           if (objd != null)
           {
               $(objd).css('display','none');
           }

           objd=document.getElementById('frm6');
           if (objd != null)
           {
               $(objd).css('display','none');
           }
    }
    if (idt_cliente>0)
    {
        var id='cpf';
        obj = document.getElementById(id);
        if (obj != null) {
            $(obj).css('background','#FFFF80');
            $(obj).css('fontSize','14px');
            $(obj).attr('readonly','true');
        }
    }
    
    if (origem=='Hora Marcada')
    {
        var id='hora_marcada_extra';
        obj = document.getElementById(id);
        if (obj != null) {
            obj.value='S';
            ConfirmaPrioridade(idt_atendimento_agenda);
            
            /*
            alert(' hora marcada '+obj.value);
            
               var id='hora_marcada_extra';
               obj = document.getElementById(id);
               if (obj != null) {
                  var cpt = obj.value;
                  alert(' 22222 hora marcada '+cpt);
               }
            */
        }
        var id='botao_hora_marcada_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }
        var id='botao_hora_extra_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }

        var id='botao_atendimento_agenda_prioridade_sim_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='botao_atendimento_agenda_prioridade_nao_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='mensagem_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='mensagem';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='hora_marcada_extra';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='tipo_pessoa';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
    }
    else
    {
        var id='botao_hora_marcada_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }
        var id='botao_hora_extra_agenda_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             //$(obj).css('visibility','hidden');
             $(obj).css('display','none');
        }

        var id='confirmacao_agendamento_bloqueio_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }
        var id='confirmacao_agendamento_canceçamento_desc';
        obj = document.getElementById(id);
        if (obj != null) {
             $(obj).css('display','none');
        }


    }
    //
    //if (idt_cliente
    var id='cliente_texto';
    obj = document.getElementById(id);
    if (obj != null) {
         $(obj).hide();
    }
    var id='cliente_texto_desc';
    obj = document.getElementById(id);
    if (obj != null) {
         $(obj).hide();
    }
    
});

function DiaSemana_t(thisw)
{
    //alert('Data '+thisw.value);
    return false;
}
function ChamaCPFEspecial(thisw)
{
    var ret = Valida_CPF(thisw);
    //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
    //var cpf = thisw.value;
    if (ret && thisw.value!='')
    {
        ChamaPessoa();
    }
    return ret;
}


function ChamaPessoa()
{
    var cpf                   = "";
    var idt_ponto_atendimento = 0;
    var $nome                 = "";
    var cnpj                  = "";
    var nome_empresa          = "";

    var telefone              = "";
    var celular               = "";
    var email                 = "";
    var idt_clientew          = 0;

    var id='cpf';
    obj = document.getElementById(id);
    if (obj != null) {
        cpf = obj.value;
    }
    var id='idt_ponto_atendimento';
    obj = document.getElementById(id);
    if (obj != null) {
        idt_ponto_atendimento = obj.value;
    }
    var id='protocolo_marcacao';
    obj = document.getElementById(id);
    if (obj != null) {
        protocolo_atendimento = obj.value;
    }
    var id='cnpj';
    obj = document.getElementById(id);
    if (obj != null) {
        cnpj = obj.value;
    }
    var id='nome_empresa';
    obj = document.getElementById(id);
    if (obj != null) {
        nome_empresa = obj.value;
    }
    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
        idt_clientew = obj.value;
    }
    if (idt_cliente>0)
    {
        //return false;
    }
    var id='telefone';
    obj = document.getElementById(id);
    if (obj != null) {
        telefone = obj.value;
    }
    var id='celular';
    obj = document.getElementById(id);
    if (obj != null) {
        celular = obj.value;
    }
    var id='email';
    obj = document.getElementById(id);
    if (obj != null) {
        email = obj.value;
    }

    //alert(' teste de guy '+idt_clientew);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=BuscaPessoa', {
        async : false,
        idt_ponto_atendimento : idt_ponto_atendimento,
        cpf : cpf,
        cnpj : cnpj,
        nome_empresa : nome_empresa,
        telefone     : telefone,
        celular      : celular,
        idt_cliente  : idt_clientew,
        email        : email
    }
    , function (str) {
        if (str == '')
        {  // pessoa sem cadastro - erro estranhao
           alert('Erro Estranho - Comunicar ao Administrador de Sistema');
        }
        else
        {
           //str = "Geraçao não foi executada"+"\n"+str
           // alert(url_decode(str).replace(/<br>/gi, "\n"));
            
            
            
            var ret = str.split('###');
            var existe             = ret[0];
            var nome               = ret[1];
            var cpf                = ret[2];
            var telefone           = ret[3];
            var celular            = ret[4];
            var email              = ret[5];
            var protocolo_marcacao = ret[6];
            var cnpj               = ret[7];
            var nome_empresa       = ret[8];
            var idt_cliente        = ret[9];



            var id='cpf';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = cpf;
            }
            var id='telefone';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = telefone;
             }
            var id='celular';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = celular;
             }
            var id='email';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = email;
            }
            var id='cnpj';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = cnpj;
            }
            var id='nome_empresa';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = nome_empresa;
             }
            var id='idt_cliente';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = idt_cliente;
             }
            var id='idt_cliente_txt';
            obj = document.getElementById(id);
            if (obj != null) {
                //obj.innerHTML = cpf+' - '+nome;
                obj.innerHTML = nome;
             }
             
             if ($existe=='S')
             {
                 var id='cliente_texto';
                 obj = document.getElementById(id);
                 if (obj != null) {
                     $(obj).hide();
                 }
             }
             else
             {
                 var id='cliente_texto';
                 obj = document.getElementById(id);
                 if (obj != null)
                 {
                     $(obj).show();
                 }
             }

         }
    });
    return false;
}

function fncListarCmbMuda_idt_cliente(idt_cliente)
{
//   alert(idt_cliente);
   ChamaPessoa();
}
</script>
