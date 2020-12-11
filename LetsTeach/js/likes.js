$(document).ready(function () {



    $(".like").click(function () {
        var id = this.id;

        $.ajax({
            url: 'megusta.php',
            type: 'POST',
            data: { id: id },
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