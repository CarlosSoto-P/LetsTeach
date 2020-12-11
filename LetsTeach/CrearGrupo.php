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
if($userData['rol']=='Estudiante')  header('Location: index.php');


if(isset($_POST['crear_send'])) {

    foreach($_POST as $calzon => $caca) {
        if($caca == '' && $calzon != "algo") $error[] = "La caja $calzon es requerida";
      }


      if (!isset($error)) {
          $query_crearGrupo = sprintf("INSERT INTO SHT_grupo (idAsesor,nombre, descripcion)  VALUES ('%s','%s','%s')",
          mysqli_real_escape_string($connLocalhost,trim($userData['idUsuario'])),
          mysqli_real_escape_string($connLocalhost,trim($_POST['nombreGrupo'])),
          mysqli_real_escape_string($connLocalhost,trim($_POST['descripcionGrupo'])));
          $res_queryCrearGrupo = mysqli_query($connLocalhost,$query_crearGrupo) or trigger_error("La query de crear grupo fallo");
        
         header ('Location: indexAsesor.php');
      }

      
}


 


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear grupo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>


    <! -- cabecera -->
        <?php include("includes/header.php"); 
        include("includes/common_functions.php");
        include("includes/barraLateralAsesor.php");
        ?>


        <!------ Include the above in your HEAD tag ---------->


        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">


                    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-7">



                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <h2>Crear un grupo</h2>
                                </div>
                                <hr>
                            </div>

                            <div style="padding-top:30px" class="panel-body">

                                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                                <form id="editarUsuario" method='post' class="form-horizontal" role="form">

                                    <div style="margin-bottom: 15px">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <div class="mt-1">
                                            <label for="nombreGrupo" class="mr-3 blockquote">Nombre del grupo</label>
                                        </div>

                                        <input type="text" class="form-control" name="nombreGrupo">
                                    </div>



                                    <div style="margin-bottom: 15px">
                                        <div class="mt-1">
                                            <label for="decripcionGrupo" class="mr-3 blockquote">Descripción del
                                                grupo</label>
                                        </div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="descripcionGrupo">
                                    </div>






                                    <div style="margin-top:20px" class="form-group float-right">
                                        <!-- Button -->
                                        <div class="col-sm-12 controls">
                                            <input class="btn btn-info" type="submit" value="Crear Grupo"
                                                name="crear_send">

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