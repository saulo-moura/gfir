<?php
$tabela = 'sca_solicitacao_acesso';
$id = 'idt';


$idt_sistema_ambiente = "";
$idt_usuario          = "";
$idt_cargo            = 0;
$nome_solicitante     = "";
$email_solicitante    = "";
$permite_login        = "";
$permite_sistema      = "";
$idt_gestor           = "";
$fecha_gestor         = "";
$fecha_administrador  = "";
$status               = "";
$idt_administrador    = "";
$sql   = 'select ';
$sql  .= '   *  ';
$sql  .= ' from sca_solicitacao_acesso ';
$sql  .= ' where idt = '.$_GET['id'];
$rs = execsql($sql);
ForEach ($rs->data as $row)
{
    $idt_sistema_ambiente = $row['idt_sistema_ambiente'];
    $idt_usuario          = $row['idt_usuario'];
    $idt_cargo            = $row['idt_cargo'];
    $nome_solicitante     = $row['nome_solicitante'];
    $email_solicitante    = $row['email_solicitante'];
    $idt_gestor           = $row['idt_gestor'];
    $permite_login        = $row['permite_login'];
    $permite_sistema      = $row['permite_sistema'];
    $status               = $row['status'];
    $fecha_gestor         = $row['fecha_gestor'];
    $fecha_administrador  = $row['fecha_administrador'];
    $idt_administrador    = $row['idt_administrador'];
    $nome_completo_login  = $row['nome_completo_login'];
    $email_completo_login = $row['email_completo_login'];
    $usuario_login        = $row['usuario_login'];
    $perfil_padrao_login  = $row['perfil_padrao_login'];
}


$js1  = "";
$js1x = "";
$gestor="";
//if ($permite_login == "S" or $permite_sistema == "S")
if ($fecha_gestor=="S")
{
    $gestor="B";
    $js1 =" readonly='true' style='background:#FFFF80;'";
    $js1x=" readonly='true' style='width:700px; background:#FFFF80;'";
}

$js2="";
if ($permite_login == "S" and $permite_sistema == "S")
{
}
else
{
    if ($permite_login == "S" )
    {
        $js2=" readonly='true' style='background:#FFFF80;' ";
    }
    else
    {
        if ($permite_sistema == "S")
        {
        }
    }
}
$crialogin="Criação de LOGIN:";
$alerta="";
if ($idt_usuario=="")
{
    echo "<div style ='text-align:center; Sheight:30px; background:#C00000; width:100%; color:#FFFFFF; font-size:14px;'>";
    echo "ATENÇÃO...<br />";
    echo "USUÁRIO SOLICITOU AUTORIZAÇÃO PARA O SISTEMA SEM INFORMAR LOGIN.<br />";
    //
    $sql   = 'select ';
    $sql  .= '   *  ';
    $sql  .= ' from usuario ';
    $sql  .= ' where email = '.aspa($email_solicitante);
    $rs = execsql($sql);
    if ($rs->rows > 0)
    {
        ForEach ($rs->data as $row)
        {
            $nome_completo  = $row['nome_completo'];
        }
        echo "<br />";
        echo "O EMAIL INFORMADO  PELO SOLICITANTE ({$email_solicitante}) JÁ ESTA EM USO POR ({$nome_completo}).<br />";
        echo "FAVOR VERIFICAR POIS SE FOR A MESMA PESSOA NÃO É NECESSÁRIO CADASTRAR NOVO LOGIN DE ACESSO.<br />";
        
        $crialogin .= "<br />";
        $crialogin .= "O EMAIL INFORMADO  PELO SOLICITANTE ({$email_solicitante}) JÁ ESTA EM USO POR ({$nome_completo}).<br />";
        $crialogin .= "FAVOR VERIFICAR POIS SE FOR A MESMA PESSOA NÃO É NECESSÁRIO CADASTRAR NOVO LOGIN DE ACESSO.<br />";

        $alerta="S";
        
        echo "<br />";
    }
    else
    {

        $sql   = 'select ';
        $sql  .= '   *  ';
        $sql  .= ' from usuario ';
        $sql  .= ' where nome_completo = '.aspa($nome_solicitante);
        $rs = execsql($sql);
        if ($rs->rows > 0)
        {
            ForEach ($rs->data as $row)
            {
                $email  = $row['email'];
            }
            echo "<br />";
            echo "O NOME INFORMADO  PELO SOLICITANTE ({$nome_solicitante}) JÁ ESTA EM USO COM EMAIL ({$email}).<br />";
            echo "FAVOR VERIFICAR POIS SE FOR A MESMA PESSOA NÃO É NECESSÁRIO CADASTRAR NOVO LOGIN DE ACESSO.<br />";
            echo "<br />";
            
            $crialogin .= "<br />";
            $crialogin .= "O NOME INFORMADO  PELO SOLICITANTE ({$nome_solicitante}) JÁ ESTA EM USO COM EMAIL ({$email}).<br />";
            $crialogin .= "FAVOR VERIFICAR POIS SE FOR A MESMA PESSOA NÃO É NECESSÁRIO CADASTRAR NOVO LOGIN DE ACESSO.<br />";
            $crialogin .= "<br />";
            $alerta="S";
      }
        else
        {
            echo "<br />";
            echo "SERÁ NECESSÁRIO CADASTRAR LOGIN DE ACESSO PARA ESSE NOVO USUÁRIO.<br />";
            echo "<br />";
            
            $crialogin .= "<br />";
            $crialogin .= "SERÁ NECESSÁRIO CADASTRAR LOGIN DE ACESSO PARA ESSE NOVO USUÁRIO.<br />";
            $crialogin .= "<br />";
            $alerta="S";
        }
    }
    echo "</div>";
}

$protocolo=$_GET['id'];
echo "<div style='text-align:center; border:1px solid #C0C0C0; background:#808080; width:100%; color:#C0C0C0; font-size:18px; font-weight : bold;'>";
echo "PROTOCOLO DE ATENDIMENTO NÚMERO <span style='font-size:28px; color:#FFFFFF;'>$protocolo</span> <br />";
echo "</div>";

$sql   = 'select ';
$sql  .= '   scaoc.idt,  ';
$sql  .= '   est.codigo as est_codigo, ';
$sql  .= '   scaos.localidade,  ';
$sql  .= '   scaos.descricao,  ';
$sql  .= '   scaoc.descricao  ';
$sql  .= ' from sca_organizacao_secao as scaos ';
$sql  .= ' left join estado est on est.idt = scaos.idt_estado ';
$sql  .= ' left join sca_organizacao_cargo scaoc on scaoc.idt_secao = scaos.idt ';
$sql  .= ' where  scaoc.idt = '.null($idt_cargo);

$sql  .= ' order by est.descricao, scaos.descricao, scaoc.descricao ';
$vetCampo['idt_cargo']        = objCmbBanco('idt_cargo', 'Cargo', False, $sql,'','width:400px; background:#FFFF80;');


$sql   = 'select ';
$sql  .= '   id_usuario, nome_completo  ';
$sql  .= ' from usuario ';
$sql  .= ' where id_usuario = '.null($idt_usuario);
$sql  .= ' order by nome_completo ';
$vetCampo['idt_usuario']        = objCmbBanco('idt_usuario', 'Usuário Solicitante', False, $sql,'','width:400px; background:#FFFF80;');

$sql   = 'select ';
$sql  .= '   id_usuario, nome_completo  ';
$sql  .= ' from usuario ';
$sql  .= ' where gestor_login = '.aspa('S');
$sql  .= ' order by nome_completo ';
$vetCampo['idt_administrador']        = objCmbBanco('idt_administrador', 'Usuário Administrador', False, $sql,' --- Informe Administrador ---','width:400px;');
//
$sql   = 'select ';
$sql  .= ' usu.id_usuario, usu.nome_completo  ';
$sql  .= ' from usuario usu ';
$sql  .= ' inner join sca_sistema_responsavel scasr on idt_responsavel = usu.id_usuario ';
$sql  .= ' inner join empreendimento em on em.idt_sistema = scasr.idt_sistema ';
$sql  .= ' where  master = '.aspa("S");
$sql  .= '   and  em.idt = '.null($idt_sistema_ambiente);


if ($fecha_gestor=="S")
{
//if ($idt_gestor!="")
//{
    $sql  .= ' and usu.id_usuario = '.null($idt_gestor);
    $sql  .= ' order by nome_completo ';
    $vetCampo['idt_gestor']        = objCmbBanco('idt_gestor', 'Usuário Gestor', False, $sql,'','width:400px; background:#FFFF80;');
}
else
{
    $sql  .= ' order by nome_completo ';
    $vetCampo['idt_gestor']        = objCmbBanco('idt_gestor', 'Usuário Gestor', False, $sql,' --- Informe Gestor Master --- ','width:400px;');
}
//
$sql   = 'select ';
$sql  .= '   em.idt,  ';
$sql  .= '   scas.sigla as scas_sigla,  ';
$sql  .= '   scas.descricao as scas_descricao,  ';
$sql  .= '   em.descricao as em_descricao  ';
$sql  .= ' from empreendimento em ';
$sql  .= ' inner join sca_sistema scas on scas.idt = em.idt_sistema ';
$sql  .= ' where  em.idt = '.null($idt_sistema_ambiente);
$sql  .= ' order by scas.descricao, em.descricao ';

$vetCampo['idt_sistema_ambiente']        = objCmbBanco('idt_sistema_ambiente', 'Sistema-Ambiente Solicitado', False, $sql,'','width:400px; background:#FFFF80;');


$jssol=" readonly='true' style='background:#FFFF80;'";

$js_st=" readonly='true' style='background:#FFFF80;'";
$js_stx=" readonly='true' style='background:#FFFF80; width:700px;'";


$vetCampo['data_solicitacao'] = objDataHora('data_solicitacao', 'Data Solicitação', false, $jssol);
$vetCampo['data_analise'] = objDataHora('data_analise', 'Data Análise', false, $js1);
$vetCampo['data_criacao_login'] = objDataHora('data_criacao_login', 'Data Criação Login', false);
$vetCampo['data_autorizacao_acesso'] = objDataHora('data_autorizacao_acesso', 'Data Autorização Acesso', false);
$vetCampo['data_status'] = objDataHora('data_status', 'Data Status', false, $js_st);



$vetStatus=Array();
$vetStatus['P']='Pendente';
$vetStatus['G']='Analisado pelo Gestor';
$vetStatus['A']='Analisado pelo Administrador';
$vetStatus['R']='Recusado o Acesso';
$vetStatus['H']='Acesso Concedido';

$status_at=$vetStatus[$status];
$vetStatus=Array();
$vetStatus[$status]=$status_at;



$vetCampo['status']          = objCmbVetor('status', 'Status', True, $vetStatus, '', $js_st );
//
$vetPerLog=Array();
$vetPerLog['I']="Não Decidido (Pendente)";
$vetPerLog['S']="Autoriza     (Aceita)";
$vetPerLog['N']="Não Autoriza (Negado)";
$vetPerSis=Array();
$vetPerSis['I']="Não Decidido (Pendente)";
$vetPerSis['S']="Autoriza     (Aceita)";
$vetPerSis['N']="Não Autoriza (Negado)";
//


$vetGestor=Array();
$vetGestor['S']="Sim. Finalisar e enviar email...";
$vetGestor['N']="Não. Analisando Solicitação...";

$vetAdministrador=Array();
$vetAdministrador['S']="Sim. Finalisar e enviar email...";
$vetAdministrador['N']="Não. Analisando Solicitação...";

if ($gestor=="")
{

}
else
{
    $ele=$vetPerLog[$permite_login];
    $vetPerLog=Array();
    $vetPerLog[$permite_login]=$ele;
    $ele=$vetPerSis[$permite_sistema];
    $vetPerSis=Array();
    $vetPerSis[$permite_sistema]=$ele;

    $ele=$vetGestor[$fecha_gestor];
    $vetGestor=Array();
    $vetGestor[$fecha_gestor]=$ele;


}

if ($fecha_administrador=="N")
{
   $js2="";
}
else
{
    $js2=" readonly='true' style='background:#FFFF80;'";
    $ele=$vetAdministrador[$fecha_administrador];
    $vetAdministrador=Array();
    $vetAdministrador[$fecha_administrador]=$ele;
}


//
$vetCampo['permite_login']   = objCmbVetor('permite_login', 'Autoriza Login?', false, $vetPerLog, '', $js1);
$vetCampo['permite_sistema'] = objCmbVetor('permite_sistema', 'Autoriza Acesso ao Sistema?', false, $vetPerSis, '',  $js1);
//
$vetCampo['nome_solicitante']      = objTexto('nome_solicitante', 'Nome do Solicitante', True, 45, 120, $jssol);

$vetCampo['mensagem_solicitante']  = objTextArea('mensagem_solicitante', 'Mensagem Solicitante', false, '' , 'width:700px', $jssol);
$vetCampo['parecer_gestor']        = objTextArea('parecer_gestor', 'Parecer Gestor', false, '' , ' width:700px; ', $js1x);
$vetCampo['parecer_administrador'] = objTextArea('parecer_administrador', 'Parecer Administrador', false, '' , 'width:700px');
$vetCampo['parecer_status']        = objTextArea('parecer_status', 'Parecer Status', false, '' , 'width:700px ', $js_stx);


$vetCampo['telefone_solicitante'] = objTelefone('telefone_solicitante', 'Telefone', True, $jssol);

$vetCampo['email_solicitante'] = objEmail('email_solicitante', 'Email Solicitante', True, 45, 45, $jssol);
//
$vetCampo['fecha_gestor']   = objCmbVetor('fecha_gestor', 'Finaliza Parecer e enviar email?', false, $vetGestor, '', $js1);
$vetCampo['fecha_administrador']   = objCmbVetor('fecha_administrador', 'Finaliza Parecer  e enviar email?', false, $vetAdministrador, '', $js2);



$vetCampo['nome_completo_login']      = objTexto('nome_completo_login', 'LOGIN - Nome Completo', True, 45, 120);
$vetCampo['email_completo_login']      = objTexto('email_completo_login', 'LOGIN - Email', True, 45, 120);
$vetCampo['usuario_login']      = objTexto('usuario_login', 'LOGIN - Usuário', True, 45, 120);
$vetCampo['perfil_padrao_login']      = objTexto('perfil_padrao_login', 'LOGIN - Perfil Padrão', True, 45, 120);



$vetGera=Array();
$vetGera['N']='Não';
$vetGera['S']='Sim';
$vetCampo['gera_login']   = objCmbVetor('gera_login', 'Gera Login?', false, $vetGera, '');
$vetCampo['gera_acesso']   = objCmbVetor('gera_acesso', 'Gera Acesso?', false, $vetGera, '');


//
MesclarCol($vetCampo['idt_usuario'], 5);
MesclarCol($vetCampo['nome_solicitante'], 5);
MesclarCol($vetCampo['idt_cargo'], 5);
MesclarCol($vetCampo['idt_sistema_ambiente'], 5);
MesclarCol($vetCampo['mensagem_solicitante'], 5);
$txtse="<div style='text-align:center; width:860px; display:block; background:#C0C0C0;'> <span style='font-size:16px;'>Solicitação do Usuário</span></div> ";
$vetFrm[] = Frame($txtse, Array(
    Array($vetCampo['idt_usuario']),
    Array($vetCampo['nome_solicitante']),
    Array($vetCampo['data_solicitacao'], '', $vetCampo['email_solicitante'], '', $vetCampo['telefone_solicitante']),
    Array($vetCampo['idt_cargo']),
    Array($vetCampo['idt_sistema_ambiente']),
    Array($vetCampo['mensagem_solicitante']),
));
$txtse="<div style='text-align:center; width:860px; display:block; background:#C0C0C0;'> <span style='font-size:16px;'>Status da Solicitação de acesso</span></div> ";

$vetFrm[] = Frame($txtse, Array(
    Array($vetCampo['status']),
    Array($vetCampo['data_status']),
    Array($vetCampo['parecer_status']),
));


$txtse="<div style='text-align:center; width:860px; display:block; background:#C0C0C0;'> <span style='font-size:16px;'>Parecer do Gestor</span></div> ";

if ($idt_usuario=="")
{

  //  if ($permite_login != "S" and $permite_sistema != "S")
  //  {
        MesclarCol($vetCampo['idt_gestor'], 5);
        MesclarCol($vetCampo['parecer_gestor'], 5);
        MesclarCol($vetCampo['fecha_gestor'], 3);

        $vetFrm[] = Frame($txtse, Array(
            Array($vetCampo['idt_gestor']),
            Array($vetCampo['data_analise'], '', $vetCampo['permite_login'], '', $vetCampo['permite_sistema']),
            Array($vetCampo['parecer_gestor']),
            Array($vetCampo['fecha_gestor']),

        ));
  //  }
    
}
else
{
   // if ($permite_sistema != "S")
   // {
        MesclarCol($vetCampo['idt_gestor'], 3);
        MesclarCol($vetCampo['parecer_gestor'], 3);
        MesclarCol($vetCampo['fecha_gestor'], 3);

        $vetFrm[] = Frame($txtse, Array(
            Array($vetCampo['idt_gestor']),
            Array($vetCampo['data_analise'], '', $vetCampo['permite_sistema']),
            Array($vetCampo['parecer_gestor']),
            Array($vetCampo['fecha_gestor']),
        ));
   // }
}

if ($fecha_gestor=="S")
{
    $txtse="<div style='text-align:center; width:860px; display:block; background:#FF0000;'> <span style='font-size:16px;'>Parecer do Administrador do Sistema oas.PCO</span></div> ";
    if ($permite_login == "S" and $permite_sistema == "S")
    {
        $vetFrm[] = Frame($txtse, Array(
            Array($vetCampo['idt_administrador']),
            Array($vetCampo['parecer_administrador']),
        ));
        if ($alerta=="S")
        {
            $txtse="<div style='text-align:center; width:860px; display:block; background:#FF0000;'> <span style='color:#FFFFFF; font-size:16px;'>$crialogin</span></div> ";
        }
        else
        {
            $txtse="<div style='text-align:center; width:860px; display:block; background:#C0C0C0;'> <span style='font-size:16px;'>$crialogin</span></div> ";
        }
        $vetFrm[] = Frame($txtse, Array(
            Array($vetCampo['nome_completo_login']),
            Array($vetCampo['usuario_login']),
            Array($vetCampo['email_completo_login']),
            Array($vetCampo['perfil_padrao_login']),
            Array($vetCampo['data_criacao_login']),
        ));
        $txtse="<div style='text-align:center; width:860px; display:block; background:#C0C0C0;'> <span style='font-size:16px;'>Executar Procedimento de Criação de LOGIN e Acesso</span></div> ";
        $vetFrm[] = Frame($txtse, Array(
            Array($vetCampo['data_autorizacao_acesso'],' ',$vetCampo['gera_login'],' ',$vetCampo['gera_acesso'],' ',$vetCampo['fecha_administrador']),
        ));


    }
    else
    {
        if ($permite_login == "S" )
        {
            $vetFrm[] = Frame($txtse, Array(
                Array($vetCampo['idt_administrador']),
                Array($vetCampo['parecer_administrador']),
                Array($vetCampo['data_criacao_login']),
                Array($vetCampo['fecha_administrador']),
            ));
        }
        else
        {
            if ($permite_sistema == "S")
            {
                $vetFrm[] = Frame($txtse, Array(
                    Array($vetCampo['idt_administrador']),
                    Array($vetCampo['parecer_administrador']),
                    Array($vetCampo['data_autorizacao_acesso']),
                    Array($vetCampo['fecha_administrador']),
                ));
            }
        }
    }
}
$vetCad[] = $vetFrm;
?>