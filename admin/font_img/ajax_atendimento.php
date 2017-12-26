<?php
Require_Once('../configuracao.php');

switch ($_GET['tipo']) {


   case 'ChamaAtendimento':
   
        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $idt_cliente            = $_POST['idt_cliente'];
        $variavel=Array();
        ChamaAtendimento($idt_atendimento_agenda,$idt_cliente,$variavel);
        echo "teste de guy $idt_atendimento_agenda ==== $idt_cliente";
    break;
    
   case 'ConfirmaAgendamento':

        $datadia   = date('d/m/Y H:i');
        $data   = explode(' ',$datadia);
        $dt     = $data[0];
        $hora   = $data[1];
        echo $dt.'###'.$hora.'###';
    break;

   case 'BloqueiaHorario':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel=Array();
        BloqueiaHorario($idt_atendimento_agenda,$variavel);
    break;

   case 'DesbloqueiaHorario':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel=Array();
        DesbloqueiaHorario($idt_atendimento_agenda,$variavel);
    break;
   case 'CancelaAgendamento':

        $idt_atendimento_agenda = $_POST['idt_atendimento_agenda'];
        $variavel=Array();
        CancelaAgendamento($idt_atendimento_agenda,$variavel);
    break;

   case 'ConfirmaChegada':

        $datadia   = date('d/m/Y H:i');
        $data   = explode(' ',$datadia);
        $dt     = $data[0];
        $hora   = $data[1];
        echo $dt.'###'.$hora.'###';
    //    echo $hora.'###';
    break;

   case 'ConfirmaLiberacao':

        $datadia   = date('d/m/Y H:i');
        $data   = explode(' ',$datadia);
        $dt     = $data[0];
        $hora   = $data[1];
        echo $dt.'###'.$hora.'###';
    //    echo $hora.'###';
    break;


}