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

//obtenemos los mienbros del grupo
$query_miembros = "SELECT 
SHT_usuario.nombres as 'nombreMiembro',
SHT_usuario.idUsuario as 'idMiembro'
from SHT_miembros
left join SHT_usuario as SHT_usuario on SHT_usuario.idUsuario = SHT_miembros.idUsuario
where SHT_miembros.idGrupo = {$_GET['idGrupo']}";
$resQuery_Miembros = mysqli_query($connLocalhost, $query_miembros) or trigger_error("El query para obtener los detalles del grupo loggeado falló");


// Recuperamos los datos del grupo
$query_grupo = "SELECT * FROM SHT_grupo WHERE idGrupo = {$_GET['idGrupo']}";
$resQuery_Grupo = mysqli_query($connLocalhost, $query_grupo) or trigger_error("El query para obtener los detalles del grupo loggeado falló");
$grupoData= mysqli_fetch_assoc($resQuery_Grupo);




//query para insertar una nueva publicaciones
$grupoID = "";
$usuarioId = "";
$boxText = "";
$boxTitle = "";

if (isset($_POST['btnPublicar'])){



$grupoID = $grupoData['idGrupo'];
$usuarioId = $userData['idUsuario'];
$boxText = $_POST['datosmsg'];
$boxTitle = $_POST['title'];
$mg = 0;
$consulta = sprintf("INSERT INTO SHT_publicacion (idGrupo,idUsuario,contenido,titulo,megustas) VALUES ('%s','%s','%s','%s','%s')",
mysqli_real_escape_string($connLocalhost, trim($grupoID)),
mysqli_real_escape_string($connLocalhost, trim($usuarioId)),
mysqli_real_escape_string($connLocalhost, trim($boxText)),
mysqli_real_escape_string($connLocalhost, trim($boxTitle)),
mysqli_real_escape_string($connLocalhost, trim($mg))


);
$resQueryMessage = mysqli_query($connLocalhost, $consulta) or trigger_error("El query falló");


}


//query para saber si el usuario esta en el grupo
$idUsuario = $userData['idUsuario'];
$idGrupo = $grupoData['idGrupo'];
$query_isMiembro =("SELECT * FROM SHT_miembros WHERE SHT_miembros.idUsuario =$idUsuario AND SHT_miembros.idGrupo =$idGrupo");
$res_queryIsMiembro = mysqli_query($connLocalhost,$query_isMiembro);





                  
?>


<!DOCTYPE html>
<html lang="es">

<head>


    <script type="text/javascript" src="js/likes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="js/likes.js"></script>
    <title>Grupo</title>
</head>

<body>






    <! -- cabecera -->
        <?php include("includes/header.php"); ?>




        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">

                        <div class="card-body">
                            <div class="h5">
                                <a href="miPerfil.php">
                                    <?php 
                                echo($userData['nombres'])
                                ?>
                                </a>

                            </div>
                            <div class="h7">


                                <?php 
                            echo($userData['descripcion'])
                            ?>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                            <div clas="h5">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 gedf-main">



                    <hr>
                    <div class="text-center bg-info text-white h1">
                       Administrador
                    </div>
                    <hr>

                    <div class="card gedf-card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    
                                </li>

                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="posts" role="tabpanel"
                                    aria-labelledby="posts-tab">
                                    <div class="form-group">
                                        <form method="post">
                                            <label class="sr-only" for="message">post</label>

                                        
                                    </div>

                                </div>

                            </div>


                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                   
                                </div>

                            </div>
                        </div>


                    </div>

                    <!---Publicaciones--->


                    <?php
                    

                    
                        //query para sacar las publicaciones de la base de datos
                            
                    if(isset($resquery_publicaciones)){


                       
                
                      
                        

                            do{
                            ?>

                    <div class="card gedf-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-2">
                                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div class="h5 m-0">

                                            <a href="perfil.php?idUsuario=<?php echo $publicaciones['idUsuario']?>">
                                                <span class="text-primary"> <?php echo($publicaciones['nombre'])?>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="h7 text-muted"><?php echo($publicaciones['apellido'])?></div>
                                        <a class="text-dark"
                                            href="grupo.php?idGrupo=<?php echo $publicaciones['idGrupo']; ?>">><?php echo($publicaciones['grupo'])?></a>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            <h5 class="text-info"><?php echo($publicaciones['titulo'])?></h5>

                            <p class="card-text">
                                <?php echo($publicaciones['contenido'])?>
                            </p>
                        </div>




                        <div id="publicaciones" class="card-footer">



                            <?php 
                            $query_megusta = sprintf("SELECT * FROM SHT_megustas WHERE idUsuario =%d AND idPublicacion = %d",
                            mysqli_real_escape_string($connLocalhost, trim($userData['idUsuario'])),
                            mysqli_real_escape_string($connLocalhost, trim($publicaciones['idPublicacion'])));

                            $resquery_query_megusta = mysqli_query($connLocalhost,$query_megusta) or trigger_error(" la query de megustas fallo");
                            
                            
                            if(mysqli_num_rows($resquery_query_megusta)==0){?>
                            <span class="like text-info"
                                id="cantidad_<?php echo $publicaciones['idPublicacion'] ?>"><?php echo $publicaciones['megustas']?></span>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>

                            <a style="cursor:pointer" class="card-link"><i class="fa fa-gittip"></i><span class="like"
                                    id="<?php echo $publicaciones['idPublicacion'] ?>">Me gusta</span></a>




                            <?php } else {?>
                            <span class="like text-info"
                                id="cantidad_<?php echo $publicaciones['idPublicacion'] ?>"><?php echo $publicaciones['megustas']?></span>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                            </svg>

                            <a style="cursor:pointer" class="card-link"><i class="fa fa-gittip"></i><span class="like"
                                    id="<?php echo $publicaciones['idPublicacion'] ?>">No me gusta</span></a>



                            <?php } ?>

                            <?php if ($userData['rol']=="Estudiante") {?>

                            <a href="responder.php?idPublicacion=<?php echo $publicaciones['idPublicacion'] ?>"
                                class="card-link"><i class="fa fa-comment"></i>Ver solución</a>
                            <?php } else{?>
                            <a href="responder.php?idPublicacion=<?php echo $publicaciones['idPublicacion'] ?>"
                                class="card-link"><i class="fa fa-comment"></i>Responder</a>
                            <?php }?>

                            <!---<a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>--->
                        </div>
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <?php } while ($publicaciones = mysqli_fetch_assoc($resquery_publicaciones));
                    }else{

                    ?>
                    <div class="text-center text-danger h1">
                        
                    </div>
                    <div class="text-center">
                        <img src="imagenes/nohay.jpg" alt="">
                    </div>

                    <?php
                    }
                    ?>




                    <!-- Post /////-->


                    <!-- Publicaciones /////-->
                </div>
                <!-- barra lateral -->
                <div class="col-md-3 float-right">


                    <div class="card">



                        <ul>
                            <h3 class="card-title">
                                <?php 
                                    echo($grupoData['nombre']);
                                ?>
                            </h3>

                        </ul>
                        <ul>



                            <h6>
                                <?php
                                    echo($grupoData['descripcion'])
                                ?>
                            </h6>
                        </ul>
                            <div class="btn-toolbar">
                          
                                <form method='post'>


                                    <button id="btnEliminar" class="btn btn-danger btn-block"
                                        name="btnEliminar">Eliminar grupo</button>

                                        <?php 
                                        include("connections/conn_localhost.php");
                                 
                                 $idg= $grupoData['idGrupo'];
                           
                                 if (isset($_POST['btnEliminar'])){
                                    
                                  // Eliminar grupos
                                     $queryDelete = ("DELETE FROM SHT_grupo WHERE idGrupo=$idg;");
                                     $resqueryDelete = mysqli_query($connLocalhost, $queryDelete) or trigger_error("El query de login de eliminar falló");
                                     // Eliminar las publicaciones del grupo
                                     $queryDeletePublicaciones = ("DELETE FROM SHT_publicacion WHERE idGrupo=$idg;");
                              $resqueryDeletePublicaciones = mysqli_query($connLocalhost, $queryDeletePublicaciones) or trigger_error("El query de login de eliminar falló");
                                    // Eliminar miembros del grupo
                                $queryDeleteMembers = ("DELETE FROM SHT_miembros WHERE idGrupo = $idg;");
                                $resqueryDelete = mysqli_query($connLocalhost, $queryDeleteMembers) or trigger_error("El query de login de eliminar falló");
                                ?>
                                <script>window.setTimeout(function() { window.location = 'http://iswug.net/webapps/LetsTeach/indexAdmin.php' }, 10);</script>
                                <?php

                                }
                               ?>
                                   

                                   
                                    
                            </div>
                            </form>




                            <?php 
                            
                            if(($userData['rol'])=="Asesor" ){

                    
                     ?>
                            <li>


                                <a href="#" class="card-link">Eliminar Miembros</a>

                            </li>
                            <?php }?>

                    </div>
                </div>





            </div>


        </div>



        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
        </script>


</body>

</html>