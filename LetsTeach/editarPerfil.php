<?php

include("connections/conn_localhost.php");

  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    

  if(!isset($_SESSION['id'])) header('Location: login.php');

  $query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);

$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$userData= mysqli_fetch_assoc($resQueryUserData);

if(isset($_POST['update_sent'])) {

if($_POST['contraseña'] != $_POST['contraseña2']){
    $error[] = "Los passwords no son coincidentes";
  }

    // Vamos a validar que no existan cajas vacias
    foreach($_POST as $calzon => $caca) {
      if($caca == '' && $calzon != "telefono") $error[] = "La caja $calzon es requerida";
    }

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
      // Preparamos la consulta para guardar el registro en la BD
      $queryUpdateUser = sprintf("UPDATE SHT_usuario SET nombres='%s', apellidos='%s', telefono='%s', correo='%s', contraseña='%s', descripcion='%s' WHERE idUsuario =%d",
        mysqli_real_escape_string($connLocalhost, trim($_POST['nombres'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['apellidos'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['telefono'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['correo'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['contraseña'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['descripcion'])),
        mysqli_real_escape_string($connLocalhost, $userData['idUsuario'])

      );

      // Ejecutamos el query
      $resQueryUserUpdate = mysqli_query($connLocalhost, $queryUpdateUser) or trigger_error("El query de actualización de usuario falló");

      // Evaluamos el resultado de la ejecución del query
      if($resQueryUserUpdate) {

        
        header("Location: index.php");
      }
    }

  }
 


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>


    <! -- cabecera -->
        <?php include("includes/header.php"); 
        include("includes/common_functions.php");
        include("includes/barraLateral.php");
        ?>


        <!------ Include the above in your HEAD tag ---------->


        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">


                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-7">



                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h2>Edita Tu Perfil</h2>
                                </div>
                                <hr>
                            </div>

                            <div style="padding-top:30px" class="panel-body">

                                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                                <form id="editarUsuario" method='post' class="form-horizontal" role="form">

                                    <div style="margin-bottom: 15px">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <div class="mt-1">
                                            <label for="nombres" class="mr-3 blockquote">Nombres</label>
                                        </div>

                                        <input type="text" class="form-control" name="nombres" value="<?php echo($userData['nombres'])?>"
                                            >
                                    </div>



                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="apellidos" class="mr-3 blockquote">Apellidos</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="apellidos" value="<?php echo($userData['apellidos'])?>"
                                           >
                                    </div>

                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="descripcion" class="mr-3 blockquote">Descripcion</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="descripcion" value="<?php echo($userData['descripcion'])?>"
                                           >
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="telefono" class="mr-3 blockquote">Telefono</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="telefono" value="<?php echo($userData['telefono'])?>"
                                            >
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="correo" class="mr-3 blockquote">Correo</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="correo" value="<?php echo($userData['correo'])?>"
                                            >
                                    </div>
                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="contraseña" class="mr-3 blockquote">Contraseña</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="password" class="form-control" name="contraseña" value=""
                                            placeholder="contraseña">
                                    </div>

                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="contraseña2" class="mr-3 blockquote">Repita la
                                                contraseña</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="password" class="form-control" name="contraseña2" value=""
                                            placeholder="Repita su contraseña">
                                    </div>






                                    <div style="margin-top:20px" class="form-group float-right">
                                        <!-- Button -->
                                        <div class="col-sm-12 controls">
                                            <input class="btn btn-info" type="submit" value="Actualizar"
                                                name="update_sent">

                                        </div>

                                    </div>





                                </form>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="bg-danger col-md-6 row ">
                    <?php
        if(isset($error)) printMsg($error, "error"); 
            ?>
                </div>
                
            </div>
            <div>










            </div>


        </div>




        <!--<div class="row">
            <div class="col-sm-6">Contenido</div>
            <div class="col-sm-6">Contenido</div>
        </div>
--->








        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
</body>

</html>