<style>
</style>

<?php
/*
echo " <div onclick='return BloqueiaHorario({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:60px;'>";
       echo " <img  title='Bloqueia Horário' src='imagens/alterar.png' border='0'>Bloqueia ";
echo " </div>";
echo " <div onclick='return DesbloqueiaHorario({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img  title='Desbloqueia Horário' src='imagens/alterar.png' border='0'>Desbloqueia ";
echo " </div>";
*/


$t1="Possibilita o Bloqueio do Horário"."\n"."Horário Bloqueado não permite Marcação.";
$t2="Possibilita o Desbloqueio do Horário"."\n"."O Horário ficará LIVRE para Marcação.";
$t3="Possibilita o Cancelamento do Horário"."\n"."Horário Cancelado não permite Marcação.";
$t4="Possibilita o Descancelamento do Horário"."\n"."O Horário ficará LIVRE para Marcação.";

if ($acao=='alt')
{
	if ($situacao=='Bloqueado')
	{
		echo " <div class='botao_ag_bl' title='{$t2}' onclick='return DesbloqueiaHorario({$idt_atendimento_agenda});' >";
				echo " <div style='margin:8px; '>Desbloquear Horário</div>";
		echo " </div>";
		echo " <div class='botao_ag_bl' title='{$t3}' onclick='return CancelaHorario({$idt_atendimento_agenda});' >";
				echo " <div style='margin:8px; '>Cancelar Horário</div>";
		echo " </div>";
	}
	else
	{
		if ($situacao=='Agendado')
		{
			echo " <div class='botao_ag_bl' title='{$t1}' onclick='return BloqueiaHorario({$idt_atendimento_agenda});' >";
					echo " <div style='margin:8px; '>Bloquear Horário</div>";
			echo " </div>";
			echo " <div class='botao_ag_bl' title='{$t3}' onclick='return CancelaHorario({$idt_atendimento_agenda});' >";
					echo " <div style='margin:8px; '>Cancelar Horário</div>";
			echo " </div>";

		}
		else
		{
			if ($situacao=='Cancelado')
			{
				echo " <div class='botao_ag_bl' title='{$t4}' onclick='return DescancelaHorario({$idt_atendimento_agenda});' >";
						echo " <div style='margin:8px; '>Descancelar Horário</div>";
				echo " </div>";
				echo " <div class='botao_ag_bl' title='{$t1}' onclick='return BloqueiaHorario({$idt_atendimento_agenda});' >";
						echo " <div style='margin:8px; '>Bloquear Horário</div>";
				echo " </div>";
			}

		
		}
	}
}

?>
<script>


var veio = '<?php echo $veio;  ?>';

function BloqueiaHorario(idt_atendimento_agenda)
{
  //  alert(' BloqueiaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=BloqueiaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
            //self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
            //alert('Bloqueio Confirmado');
			alert('O sistema não conseguio executar esse Procedimento.');
         }
         else
         {
		 var ret = str.split('###');
            retorno = ret[0];
            if (retorno==1)
			{
				self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda+'&veio='+veio;
				alert('Sucesso. Agenda Bloqueada.');
				return false;
			}
	        if (retorno==3)
			{
  			    alert('Agenda com Cliente Marcado. Não pode Bloqueiar.');
				return false;
			}
			if (retorno==4)
			{
  			    alert('Status da Agenda não permite Bloqueio.');
				return false;
			}
			if (retorno==2)
			{
  			    str = 'Não conseguiu acesso ao Registro da Agenda.'+ "\n"+str ;
			}
			if (retorno==0)
			{
  			    str = 'Erro interno na rotina.'+ "\n"+str ;
			}
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    
    
    
    return false;
}

function DesbloqueiaHorario(idt_atendimento_agenda)
{
//    alert(' DesbloqueiaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=DesbloqueiaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
//           self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
//           alert('Desbloqueio Confirmado');
             alert('O sistema não conseguio executar esse Procedimento.');
         }
         else
         {
		 
		    var ret = str.split('###');
            retorno = ret[0];
            if (retorno==1)
			{
				self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda+'&veio='+veio;
  			    alert('Sucesso. Agenda Desbloqueada.');
				return false;
			}
	        if (retorno==2)
			{
  			    str = 'Não conseguiu acesso ao Registro da Agenda.'+ "\n"+str ;
			}
			if (retorno==4)
			{
  			    alert('Status da Agenda não permite Desbloqueio.');
				return false;
			}
            //   
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    return false;
}








function CancelaHorario(idt_atendimento_agenda)
{
  //  alert(' CancelaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=CancelaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
            //self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
            //alert('Bloqueio Confirmado');
			alert('O sistema não conseguio executar esse Procedimento.');
         }
         else
         {
		 var ret = str.split('###');
            retorno = ret[0];
            if (retorno==1)
			{
				self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda+'&veio='+veio;
				alert('Sucesso. Agenda Cancelada.');
				return false;
			}
	        if (retorno==3)
			{
  			    alert('Agenda com Cliente Marcado. Não pode Cancelar.');
				return false;
			}
			if (retorno==4)
			{
  			    alert('Status da Agenda não permite Cancelar.');
				return false;
			}
			if (retorno==2)
			{
  			    str = 'Não conseguiu acesso ao Registro da Agenda.'+ "\n"+str ;
			}
			if (retorno==0)
			{
  			    str = 'Erro interno na rotina.'+ "\n"+str ;
			}
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    
    
    
    return false;
}


function DescancelaHorario(idt_atendimento_agenda)
{
//    alert(' DescancelaHorario = '+idt_atendimento_agenda);
    
    var str = '';
    $.post('ajax_atendimento.php?tipo=DescancelaHorario', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda
    }
    , function (str) {
        if (str == '')
        {
//           self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda;
//           alert('Desbloqueio Confirmado');
             alert('O sistema não conseguio executar esse Procedimento.');
         }
         else
         {
		 
		    var ret = str.split('###');
            retorno = ret[0];
            if (retorno==1)
			{
				self.location= 'conteudo.php?acao=alt&texto0=&prefixo=cadastro&menu=grc_atendimento_agenda&id='+idt_atendimento_agenda+'&veio='+veio;
  			    alert('Sucesso. Agenda Descancelada.');
				return false;
			}
	        if (retorno==2)
			{
  			    str = 'Não conseguiu acesso ao Registro da Agenda.'+ "\n"+str ;
			}
			if (retorno==4)
			{
  			    alert('Status da Agenda não permite Descancelamento.');
				return false;
			}
            //   
            alert(url_decode(str).replace(/<br>/gi, "\n"));
         }
    });

    
    return false;
}






</script>