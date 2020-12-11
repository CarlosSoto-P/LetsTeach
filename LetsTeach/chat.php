<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>

 <?php
 
 include("connections/conn_localhost.php");
 include("includes/common_functions.php");


 
    $consulta = "SELECT * FROM SHT_message ;";
    $resQueryMessage = mysqli_query($connLocalhost, $consulta) or trigger_error("El query falló");
        while ($fila = $resQueryMessage->fetch_array()): 
?>
    <div id="data-chat">
            <span style="color:#1c62c4;"><?php echo $fila['idnombre'] ?>: </span>
             <span style="color:#848484;"><?php echo $fila['mensaje'] ?></span>
             <span style="float:right;"><?php echo formatfecha($fila['fecha']) ?></span>
    </div>
<?php endwhile;?>
</body>
</html>




