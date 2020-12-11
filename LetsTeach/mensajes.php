<?php
include "connections/conn_localhost.php";

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');

$query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);

$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$userData= mysqli_fetch_assoc($resQueryUserData);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mssgstyle.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Mukta+Vaani:wght@200&display=swap" rel="stylesheet">
<script type="text/javascript">
    function ajax() {
    var req = new XMLHttpRequest();
    req.onreadystatechange =  function () {
        if (req.readyState == 4 && req.status == 200) {
            document.getElementById('chat').innerHTML = req.responseText;
        }
        
    }
    req.open('GET','chat.php');
    req.send();    
}
//refrescar la pagina cada segundo
setInterval(function(){ajax();},1000);
</script>


</head>

<body onLoad= "ajax();">


<! -- cabecera -->
        <?php include("includes/headerChat.php"); ?>
      
<div id= "container">
    <div id="box-chat">
        <div id="chat"> </div>
    </div>

    <form action="mensajes.php" method="post">
    

    <input type="text" name = "nombre" placeholder =<?php echo $userData['nombres'] ?> disabled>
    <textarea name="mensaje"placeholder = "Ingresa tu mensaje"></textarea>
    <input class = 'pulse' type="submit" name ="send" value = "Enviar">
    </form>
  
    <?php
  
     $mensaje ="";
    
    
    if (isset($_POST['send'])) {
    
        $nombre = $userData['nombres'];
        $mensaje = $_POST['mensaje'];
if (!empty($mensaje)) {
    $consulta = sprintf("INSERT INTO SHT_message (idnombre, mensaje) VALUES ('%s','%s')",
    mysqli_real_escape_string($connLocalhost, trim($nombre)),
    mysqli_real_escape_string($connLocalhost, trim($_POST['mensaje']))

   
);
$resQueryMessage = mysqli_query($connLocalhost, $consulta) or trigger_error("El query falló");

    
}
    
     }
    ?>
</div>


</body>
</html>