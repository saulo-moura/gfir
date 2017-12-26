<style>



.botao_ag_e {
    width:300px;
    height:50px;
} 

</style>

<?php
/*
echo " <div onclick='return ChamaAtendimento({$idt_atendimento_agenda});' style='color:#004080; font-size:14px; cursor:pointer; float:left; padding-top:20px; padding-right:20px;'>";
       echo " <img   title='Chama Atendimento' src='imagens/alterar.png' border='0'> Atender Cliente";
echo " </div>";
*/



echo " <div class='botao_ag botao_ag_e' onclick='return ChamaAtendimento({$idt_atendimento_agenda});' >";
        echo " <div style='margin:15px; '>Chama Cliente para atendimento</div>";
echo " </div>";


?>
<script type="text/javascript">
function ChamaAtendimento(idt_atendimento_agenda)
{
    alert(' Chama Atendimento = '+idt_atendimento_agenda);
    var idt_cliente = 0;
    
    var id='idt_cliente';
    obj = document.getElementById(id);
    if (obj != null) {
       // obj.style.background = obj.value;
       //  obj.style.color = obj.value;
       idt_cliente=obj.value;
    }
//////////////////////////
    var str = '';
    $.post('ajax_atendimento.php?tipo=ChamaAtendimento', {
        async : false,
        idt_atendimento_agenda : idt_atendimento_agenda,
        idt_cliente            : idt_cliente
    }
    , function (str) {
        if (str == '') {
        //    self.location = 'conteudo.php?prefixo=listar&texto0=&menu=gec_metodologia';
        } else {
            alert(url_decode(str).replace(/<br>/gi, "\n"));
        }
    });
///////////////////
    
    
    return false;
}
</script>