<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
$(function(){
    pegaNotificacoes();
});

function pegaNotificacoes(timestamp){
    var data = {};
    if(typeof timestamp != 'undefined')
        data.timestamp = timestamp;

    $.post('longpolling.php', data, function(res){
        // mostra as notificaçoes
        for(i in res.notificacoes){
            $('#resultados').append(res.notificacoes[i].notificacao+'<br>');
        }

        pegaNotificacoes(res.timestamp);
    }, 'json');
}
</script>

<div id="resultados"></div>