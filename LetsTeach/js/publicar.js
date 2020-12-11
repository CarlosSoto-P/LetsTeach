$(document).ready(function () {
    $(".publicar").click(function () {
        var id = this.id;

        $.ajax({
            url: 'publicar.php',
            type: 'POST',
            data: { tile: id },
            dataType: 'json',

            success: function (data) {
                var texto = data['text'];
                var cantidad = data['likes'];
                $("#"+id).text(texto);
                $("#cantidad_"+id).text(cantidad);
                

            }

        });

        

    });



});