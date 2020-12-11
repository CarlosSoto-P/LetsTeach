
<?php

include("connections/conn_localhost.php");

// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['id'])) header('Location: login.php');


// obtenemos la informacion del usuario 
$query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
);
$resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");
$userData= mysqli_fetch_assoc($resQueryUserData);

// Recuperamos los datos del grupo
$query_grupo = "SELECT * FROM SHT_grupo WHERE idGrupo = {$_GET['idGrupo']}";
$resQuery_Grupo = mysqli_query($connLocalhost, $query_grupo) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$grupoData= mysqli_fetch_assoc($resQuery_Grupo);

//query para el numero de integrantes 
$query_numeroDeIntegrantes = "SELECT count(*) as total from SHT_miembros
where idGrupo={$_GET['idGrupo']};";
$resQuery_NumeroMiembros = mysqli_query($connLocalhost, $query_numeroDeIntegrantes) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$numero = mysqli_fetch_assoc($resQuery_NumeroMiembros);

//obtenemos la informacion del asesor 
$query_Asesor = "SELECT 
SHT_usuario.nombres as 'nombreAsesor',
SHT_usuario.idUsuario as 'idAsesor',
SHT_usuario.rol as 'rol',
SHT_usuario.apellidos as 'apellidos',
SHT_usuario.descripcion as 'descripcion',
SHT_usuario.telefono as 'telefono',
SHT_usuario.correo as 'correo'
from SHT_grupo
left join SHT_usuario as SHT_usuario on SHT_usuario.idUsuario = SHT_grupo.idAsesor
where SHT_grupo.idGrupo = {$_GET['idGrupo']}";
$resQuery_Asesor = mysqli_query($connLocalhost, $query_Asesor) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$asesorData = mysqli_fetch_assoc($resQuery_Asesor);


//obtenemos los mienbros del grupo
$query_miembros = "SELECT 
SHT_usuario.nombres as 'nombreMiembro',
SHT_usuario.idUsuario as 'idMiembro'
from SHT_miembros
left join SHT_usuario as SHT_usuario on SHT_usuario.idUsuario = SHT_miembros.idUsuario
where SHT_miembros.idGrupo = {$_GET['idGrupo']}";
$resQuery_Miembros = mysqli_query($connLocalhost, $query_miembros) or trigger_error("El query para obtener los detalles del grupo loggeado falló");

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
?>
 
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Informacion del grupo</title>
</head>
<body>



 
    <?php include("includes/header.php"); ?>
    <div class="container">
            <div class="main-body">

                
                <!--nombre y descripcion-->
                <div class="row gutters-sm">
                    <div class="col-md-3 mb-3">
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <h5>
                                        Asesor
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                        class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4>
                                            <?php 
                                                echo($asesorData['nombreAsesor']." ".$asesorData['apellidos'])
                                            ?>
                                        </h4>
                                        <p class="text-secondary mb-1">
                                            <?php 
                                                echo($asesorData['descripcion'])
                                            ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Informacion-->                          
                    <div class="col-md-9">
                        <hr>
                        <div class="card mb-3">
                            
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nombre Del Grupo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($grupoData['nombre'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Descripcion</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($grupoData['descripcion'])
                                        ?>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Numero de integrantes</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($numero['total']);
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Asesor</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($asesorData['nombreAsesor']." ".$asesorData['apellidos'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Telefono de contacto</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                             echo($asesorData['telefono'])
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Correo de contacto</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php 
                                            echo($asesorData['correo'])
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <!-- barra lateral -->
              
                   
                </div>
                    
                </div>
       
           


    
    
</body>
</html>