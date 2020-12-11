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
  $queryLoggedUserDetail = "SELECT * FROM SHT_usuario WHERE idUsuario = {$_SESSION['id']}";

  // Ejecutamos el query
  $resQueryLoggedUserDetail = mysqli_query($connLocalhost, $queryLoggedUserDetail) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

  // Hacemos un fetch del resultado obtenido
  $loggedUserDetail = mysqli_fetch_assoc($resQueryLoggedUserDetail);


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
                                       echo($loggedUserDetail['nombres']." ".$loggedUserDetail['apellidos'])
                                       ?>
                                        </h4>
                                        <p class="text-secondary mb-1">
                                            <?php 
                                       echo($loggedUserDetail['descripcion'])
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
                                       echo($loggedUserDetail['nombres']." ".$loggedUserDetail['apellidos'])
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
                                       echo($loggedUserDetail['correo'])
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
                                       echo($loggedUserDetail['telefono'])
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
                                       echo($loggedUserDetail['rol'])
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
                                       echo($loggedUserDetail['descripcion'])
                                       ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

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
                </div>


</body>

</html>