<style>

</style>
<?php

$tabela = 'grc_atendimento_avulso';
$id = 'idt';

$idt_atendimento_avulso = $_GET['id'];
//$vetCampo['protocolo']        = objAutonum('protocolo', 'Senha',15,true);

$TabelaPai    = "".db_pir."sca_organizacao_secao";
$AliasPai     = "grc_os";
$EntidadePai  = "Ponto de Atendimento";
$idPai        = "idt";
$CampoPricPai = "idt_ponto_atendimento";

$idt_ponto_atendimento = $_GET['idt0'];
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";

$vetCampo['protocolo']        = objTexto('protocolo', 'Senha de Chegada',false,15,45,$js);

$js         = " style='display:none;' ";
$js         = "";

$vetCampo['protocolo_marcacao']        = objTexto('protocolo_marcacao', 'Protocolo de Marcação',false,15,45,$js);




$js    = " readonly='true' style='width:150px; background:#FFFF80; font-size:14px;' ";

$vetCampo['data_atendimento'] = objDatahora('data_atendimento', 'Data da Chegada', False,$js);

$vetCampo['nome']             = objTexto('nome', 'Nome completo do Cliente', True, 40, 120);
//$vetCampo['assunto']          = objTexto('assunto', 'Resumo do Assunto', false, 55, 120);

$vetCampo['nome_empresa']             = objTexto('nome_empresa', 'Nome completo da Empresa', false, 40, 120);


$js         = " visibility='hidden' ";
$vetCampo['tipo_pessoa']      = objCmbVetor('tipo_pessoa', 'Prioridade?', false, $vetSimNao,'',$js);

$js=" style='width:160px; ' ";
$vetCampo['telefone']         = objTelefone('telefone', 'Telefone de Contato', false, $js);
$vetCampo['celular']          = objTelefone('celular', 'Celular de Contato', false, $js);
$jst="  ChamaCPFEspecial(this)  ";
$vetCampo['cpf']              = objCPF('cpf', 'CPF do Cliente', false,true,'',$jst);
$vetCampo['email']            = objEmail('email', 'Email de Contato', false, 40, 120,'S');


$vetCampo['cnpj']             = objCNPJ('cnpj', 'CNPJ da Empresa', false);

$maxlength  = 2000;
$style      = "width:830px;  background:#FFFF80; font-size:40px;";
$js         = " readonly='true' ";
$vetCampo['mensagem'] = objTextArea('mensagem', 'Forma de atendimento na Fila', false, $maxlength, $style, $js);


$maxlength  = 2000;
$style      = "width:830px; ";
$js         = "";

$vetCampo['assunto'] = objTextArea('assunto', 'Resumo do Assunto', false, $maxlength, $style, $js);

//  PORTE Faturamento (Não tem Tabela)
// $sql  = "select idt,codigo, descricao from grc_projeto ";
//$sql .= " order by descricao";
//$vetCampo['idt_projeto'] = objCmbBanco('idt_projeto', 'Projeto', false, $sql,' ','width:500px;');

$vetCampow=$vetCampo;

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro="REGISTRO DA CHEGADA PARA ATENDIMENTO - SOLICITAR SENHA";


$vetFrm = Array();

//$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

// Definição de um frame ou seja de um quadro da tela para agrupar campos

//$vetCampo['botao_atendimento_avulso'] = objInclude('botao_atendimento_avulso', 'cadastro_conf/botao_atendimento_avulso.php');

$vetCampo['botao_atendimento_avulso_prioridade_sim'] = objInclude('botao_atendimento_avulso_prioridade_sim', 'cadastro_conf/botao_atendimento_avulso_prioridade_sim.php');

$vetCampo['botao_atendimento_avulso_prioridade_nao'] = objInclude('botao_atendimento_avulso_prioridade_nao', 'cadastro_conf/botao_atendimento_avulso_prioridade_nao.php');





$vetCampo['botao_hora_marcada'] = objInclude('botao_hora_marcada', 'cadastro_conf/botao_hora_marcada.php');
$vetCampo['botao_hora_extra']   = objInclude('botao_hora_extra', 'cadastro_conf/botao_hora_extra.php');
$js         = " visibility='hidden' ";
$vetCampo['hora_marcada_extra']      = objCmbVetor('hora_marcada_extra', 'Hora Marcada?', false, $vetSimNao,'',$js);



//MesclarCol($vetCampo['mensagem'], 3);
MesclarCol($vetCampo['assunto'], 5);
MesclarCol($vetCampo['tipo_pessoa'], 5);

MesclarCol($vetCampo['mensagem'], 5);

//MesclarCol($vetCampo['protocolo_marcacao'], 5);

/*
MesclarCol($vetCampo['data_atendimento'], 3);
MesclarCol($vetCampo['botao_hora_extra'], 3);
MesclarCol($vetCampo['botao_atendimento_avulso_prioridade_nao'], 3);
MesclarCol($vetCampo['nome_empresa'], 3);
MesclarCol($vetCampo['celular'], 3);
*/
//MesclarCol($vetCampo['data_atendimento'], 3);
//MesclarCol($vetCampo['botao_hora_extra'], 3);
//MesclarCol($vetCampo['data_atendimento'], 3);
//MesclarCol($vetCampo['botao_hora_extra'], 3);
//MesclarCol($vetCampo['botao_atendimento_avulso_prioridade_nao'], 3);
//MesclarCol($vetCampo['nome_empresa'], 3);


//$vetFrm[] = Frame('<span></span>', Array(
//    Array($vetCampo[$CampoPricPai]),
//),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame("<span>{$titulo_cadastro}</span>", Array(
    Array($vetCampo['protocolo'],'',$vetCampo['data_atendimento'],'', $vetCampo[$CampoPricPai]),
    Array($vetCampo['botao_hora_marcada'],'',$vetCampo['botao_hora_extra'],'','',),
    //Array($vetCampo['protocolo_marcacao']),

    Array($vetCampo['protocolo_marcacao'],'',$vetCampo['cpf'],'', $vetCampo['nome']),

    Array($vetCampo['telefone'],'',$vetCampo['celular'],'',$vetCampo['email']),

    
    Array('','',$vetCampo['botao_atendimento_avulso_prioridade_sim'],'',$vetCampo['botao_atendimento_avulso_prioridade_nao']),
    Array($vetCampo['hora_marcada_extra']),
    Array($vetCampo['mensagem']),

    Array($vetCampo['cnpj'],'','','', $vetCampo['nome_empresa']),

    Array($vetCampo['assunto']),

    Array($vetCampo['tipo_pessoa']),
    

),$class_frame,$class_titulo,$titulo_na_linha);




$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {

           muda_size_font(18);
           objd=document.getElementById('protocolo_marcacao_desc');
           if (objd != null)
           {
               //$(objd).css('display','none');
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('protocolo_marcacao');
           if (objd != null)
           {

            //   $(objd).css('display','none');
               $(objd).css('visibility','hidden');

           }



        
        
    });
    
function ChamaCPFEspecial(thisw)
{
    var ret = Valida_CPF(thisw);
    //alert('xxx acessar pessoa '+thisw.value+ ' == '+ ret );
    //var cpf = thisw.value;
    ChamaPessoa();
    return ret;
}


function ChamaPessoa()
{

    var cpf                   = "";
    var idt_ponto_atendimento = 0;
    var $nome                 = "";
    var protocolo_marcacao    = "";
    
    var cnpj                  = "";
    var nome_empresa          = "";
    
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
    var id='nome';
    obj = document.getElementById(id);
    if (obj != null) {
        nome = obj.value;
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

    var str = '';
    $.post('ajax_atendimento.php?tipo=BuscaPessoa', {
        async : false,
        idt_ponto_atendimento : idt_ponto_atendimento,
        protocolo_marcacao    : protocolo_marcacao,
        cpf : cpf,
        nome: nome,
        cnpj: cnpj,
        nome_empresa: nome_empresa
        
    }
    , function (str) {
        if (str == '')
        {  // pessoa sem cadastro - erro estranhao
           alert('Erro Estranho - Comunicar ao Administrador de Sistema');
        }
        else
        {
           //str = "Geraçao não foi executada"+"\n"+str
            alert(url_decode(str).replace(/<br>/gi, "\n"));
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

            
            var id='nome';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = nome;
             }
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
            var id='protocolo_marcacao';
            obj = document.getElementById(id);
            if (obj != null) {
                obj.value = protocolo_marcacao;
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


         }
    });
    return false;
}
</script>


