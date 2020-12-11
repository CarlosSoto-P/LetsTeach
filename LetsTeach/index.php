<?php
  include("connections/conn_localhost.php");

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
  if($userData['rol']=='Asesor')  header('Location: indexAsesor.php');
  if($userData['rol']=='Admin')  header('Location: indexAdmin.php');

  //consusltar grupos en los que este el usuario

  $query_ingrupo = sprintf("SELECT
  SHT_grupo.idGrupo AS 'idGrupo',
  SHT_grupo.nombre AS 'nombreGrupo'
  FROM SHT_miembros 
  LEFT JOIN SHT_grupo AS SHT_grupo ON  SHT_grupo.idGrupo = SHT_miembros.idGrupo
  LEFT JOIN SHT_usuario AS SHT_usuario on SHT_usuario.idUsuario = SHT_miembros.idUsuario
  WHERE SHT_miembros.idUsuario = %d",
mysqli_real_escape_string($connLocalhost, trim($userData['idUsuario']))
);

$resquery_ingrupo = mysqli_query($connLocalhost, $query_ingrupo) or trigger_error("El query para obtener los detalles del usuario loggeado falló");


$resquery_ingrupo2 = mysqli_query($connLocalhost, $query_ingrupo) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

$inGrupo = mysqli_fetch_assoc($resquery_ingrupo);
//consultar los amigos





?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="js/likes.js"></script>



    <title>Let's Teach</title>


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
                        <div class="card-body">
                            <div class="h5">
                                <h5 class="text-primary">Estas en estos grupos</h5>



                            </div>
                            <div clas="h5">




                                <?php

                                if(mysqli_num_rows($resquery_ingrupo)){

                            do{
                            ?>
                                <ul>
                                    <li>
                                        <a href="grupo.php?idGrupo=<?php echo $inGrupo['idGrupo']; ?>"
                                            class="text-dark">

                                            <?php 
                                        echo($inGrupo['nombreGrupo']);
                                        ?>
                                        </a>
                                    </li>
                                </ul>

                                <?php 
                                //lleno por cada fecth el id de los grupos
                                $idGrupos []= $inGrupo['idGrupo']; 
                                
                            } while ($inGrupo = mysqli_fetch_assoc($resquery_ingrupo));
                           
                        }else{
                            
                        
                                ?>

                                <div class="text-center text-danger h5">

                                    upss!! aun no estas en un grupo

                                </div>
                                <?php

                        }
                                ?>


                            </div>
                        </div>
                    </div>


                    <?php
                    //consultar grupos

                    $query_grupos =("SELECT * FROM SHT_grupo LIMIT 10");
                    $resquery_grupos = mysqli_query($connLocalhost, $query_grupos);
                    $grupos = mysqli_fetch_assoc($resquery_grupos);


                    ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="h5">
                                <h5 class="text-primary">Algunos Grupos</h5>
                            </div>
                            <div clas="h5">
                                <ul>

                                    <?php
                                    do {
                                ?>

                                    <li>
                                        <a href="grupo.php?idGrupo=<?php echo $grupos['idGrupo']; ?>" class="text-dark">
                                            <?php
                                                echo($grupos['nombre'])

                                            ?>


                                        </a>
                                    </li>

                                    <?php
                                    }while ($grupos =mysqli_fetch_assoc($resquery_grupos));
                                    
                                    ?>




                                </ul>
                            </div>
                        </div>
                    </div>


                </div>



                <div class="col-md-6 gedf-main">


                    <hr>
                    <div class="text-center bg-info text-white h1">
                        Publicaciones de tus Grupos
                    </div>
                    <hr>

                    <!--- \\\\\\\publicaciones-->

                    <?php

                    
                        //query para sacar las publicaciones de la base de datos
                            
                    if(isset($idGrupos)){


                        $ids = implode(",",$idGrupos);
                        
                        $query_publicaciones = ("SELECT 
                        SHT_usuario.idUsuario as 'idUsuario',
                        SHT_usuario.nombres as 'nombre',
                        SHT_usuario.apellidos as 'apellido',
                        SHT_grupo.idGrupo as 'idGrupo',
                        SHT_grupo.nombre as 'grupo',
                        SHT_publicacion.titulo as 'titulo',
                        SHT_publicacion.contenido as 'contenido',
                        SHT_publicacion.megustas as 'megustas',
                        SHT_publicacion.idPublicacion as 'idPublicacion'
                        from SHT_publicacion
                        LEFT JOIN SHT_usuario as SHT_usuario ON SHT_usuario.idUsuario = SHT_publicacion.idUsuario
                        LEFT JOIN SHT_grupo as SHT_grupo ON SHT_grupo.idGrupo = SHT_publicacion.idGrupo
                        where SHT_publicacion.idGrupo  in ($ids) ORDER BY idPublicacion DESC");

                        $resquery_publicaciones = mysqli_query($connLocalhost, $query_publicaciones);
                        $publicaciones = mysqli_fetch_assoc($resquery_publicaciones);
                        

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
                                        <a class="text-dark" href="grupo.php?idGrupo=<?php echo $publicaciones['idGrupo']; ?>">><?php echo($publicaciones['grupo'])?></a>
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

                            <a href="responder.php?idPublicacion=<?php echo $publicaciones['idPublicacion'] ?>" class="card-link"><i class="fa fa-comment"></i>Ver solución</a>


                            <!---<a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>--->
                        </div>
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <?php } while ($publicaciones = mysqli_fetch_assoc($resquery_publicaciones));
                    }else{

                    ?>
                    <div class="text-center text-danger h1">
                        Registrate a un grupo primero
                    </div>
                    <div class="text-center">
                        <img src="imagenes/nohay.jpg" alt="">
                    </div>

                    <?php
                    }
                    ?>




                    <!-- Post /////-->
                </div>
                <!-- barra lateral -->
                <?php include("includes/barraLateral.php"); ?>

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