<?php 
include("connections/conn_localhost.php");

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');

// query para obtener la informacion del usuario 
$query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);
$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");
$userData= mysqli_fetch_assoc($resQueryUserData);


if($userData['rol'] =="Estudiante") header("Location: index.php");

$idGrupo = $_GET['idGrupo'];
$query_miembros =("SELECT 
SHT_usuario.nombres as 'nombre',
SHT_usuario.apellidos as 'apellido',
SHT_usuario.idUsuario as 'idUsuario',
SHT_miembros.idGrupo as 'idGrupo'
from SHT_miembros
left join SHT_usuario as SHT_usuario on SHT_usuario.idUsuario = SHT_miembros.idUsuario
where SHT_miembros.idGrupo = $idGrupo");

$res =mysqli_query($connLocalhost,$query_miembros);
$miembros = mysqli_fetch_assoc($res);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar miembros</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>

<body>

    <?php include("includes/header.php"); ?>
    <br><br>
    <div class="bg-info">

        <h1 class="text-center text-white">
            Miembros
        </h1>


    </div>
<br><br>

    <?php  
     if(mysqli_num_rows($res)){

do {

   
    
?>
    <h2>
        <?php echo $miembros['nombre']." ".$miembros['apellido']?>

    </h2> <span><a href="includes/eliminarMiembro.php?idMiembro=<?php echo $miembros['idUsuario']?>&idGrupo=<?php echo $miembros['idGrupo']?>">Eliminar</a></span>
    
     <br>

    <?php }while($miembros = mysqli_fetch_assoc($res));

}else{

    ?>

    <div>
    <h1 class="text-danger">No hay miembros</h1>
    </div>
<?php 
}
?>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
</body>

</html>