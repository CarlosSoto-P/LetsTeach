<?php
  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    

  if(!isset($_SESSION['id'])) header('Location: login.php');


  // Incluimos la conexión a la base de datos

    

  }

  include("connections/conn_localhost.php");
  include("includes/common_functions.php");

  // Recuperamos los datos del usuario tomando la referencia de $_SESSION
  $query_perfil = "SELECT * FROM SHT_usuario WHERE idUsuario = {$_GET['idUsuario']}";

  // Ejecutamos el query
  $resquery_perfil = mysqli_query($connLocalhost, $query_perfil) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

  // Hacemos un fetch del resultado obtenido
  $perfil = mysqli_fetch_assoc($resquery_perfil);


  //sacar los grupos donde esta el usuario.
  $query_ingrupo = sprintf("SELECT
  SHT_grupo.idGrupo AS 'idGrupo',
  SHT_grupo.nombre AS 'nombreGrupo',
  SHT_grupo.descripcion AS 'descripcionGrupo'
  FROM SHT_miembros 
  LEFT JOIN SHT_grupo AS SHT_grupo ON  SHT_grupo.idGrupo = SHT_miembros.idGrupo
  LEFT JOIN SHT_usuario AS SHT_usuario on SHT_usuario.idUsuario = SHT_miembros.idUsuario
  WHERE SHT_miembros.idUsuario = %d",
mysqli_real_escape_string($connLocalhost, trim($_GET['idUsuario']))
);

$resquery_ingrupo = mysqli_query($connLocalhost, $query_ingrupo) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$inGrupo = mysqli_fetch_assoc($resquery_ingrupo);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>

<body>


    <! -- cabecera -->
        <?php include("includes/header.php"); ?>
        <?php include("includes/barraLateral.php"); ?>

        <hr>

        <div class="container">
            <div class="main-body">



                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>
                                            <?php 
                                       echo($perfil['nombres']." ".$perfil['apellidos'])
                                       ?>
                                        </h4>
                                        <p class="text-secondary mb-1">
                                            <?php 
                                       echo($perfil['descripcion'])
                                       ?>
                                        </p>




                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nombre Completo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                       echo($perfil['nombres']." ".$perfil['apellidos'])
                                       ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Correo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                       echo($perfil['correo'])
                                       ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telefono</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                       echo($perfil['telefono'])
                                       ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Rol</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                       echo($perfil['rol'])
                                       ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mi descripción</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                       echo($perfil['descripcion'])
                                       ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>





                </div>

                <?php
                    if($perfil['rol']=="Estudiante"){
                ?>
                <div class="h1 bg-primary text-white text-center">
                    Esta unido a estos grupos
                </div>
                <?php
                
                do{

                ?>
                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ml-2">
                                    <div class="h5 m-0">

                                        <a href="grupo.php?idGrupo=<?php echo $inGrupo['idGrupo']; ?>"><?php echo $inGrupo['nombreGrupo']?>
                                        </a>
                                    </div>
                                    <div class="h7 text-black"> <?php echo $inGrupo['descripcionGrupo']?></div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php }while($inGrupo = mysqli_fetch_assoc($resquery_ingrupo))?>
                <?php } else {
                    ?>
                <div class="h1 bg-primary text-white text-center">
                    Grupos del Asesor
                </div>
                <?php
                $idAsesor= $perfil['idUsuario'];
                $query_gruposCreados =("SELECT * FROM grupo WHERE idAsesor = $idAsesor");
                $res = mysqli_query($connLocalhost,$query_gruposCreados);
                $creados=mysqli_fetch_assoc($res);
                
                do{

                ?>
                <div class="card gedf-card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ml-2">
                                    <div class="h5 m-0">

                                        <a href="grupo.php?idGrupo=<?php echo $creados['idGrupo']; ?>"><?php echo $creados['nombre']?>
                                        </a>
                                    </div>
                                    <div class="h7 text-black"> <?php echo $creados['descripcion']?></div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } while($creados = mysqli_fetch_assoc($res));
                }
                
                ?>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                    crossorigin="anonymous">
                </script>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                    crossorigin="anonymous">
                </script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
                    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
                    crossorigin="anonymous">
                </script>
</body>

</html>