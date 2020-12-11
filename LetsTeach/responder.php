<?php 
  include("connections/conn_localhost.php");
  include("includes/common_functions.php");

  if(!isset($_SESSION)) {
    session_start();
  }
  if(!isset($_SESSION['id'])) header('Location: login.php');


  $query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
  mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
  );
  $resquery_userData = mysqli_query($connLocalhost,$query_userData);
  $userData = mysqli_fetch_assoc($resquery_userData);
 

  $id = $_GET['idPublicacion'];
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
  where SHT_publicacion.idPublicacion = $id");

  $resquery_publicaciones = mysqli_query($connLocalhost, $query_publicaciones);
  $publicacion= mysqli_fetch_assoc($resquery_publicaciones);

//insertar comentario
  if(isset($_POST['responder_send'])){

    foreach($_POST as $calzon => $caca) {
        if($caca == '' && $calzon != "telefono") $error[] = "La caja $calzon es requerida";
      }


      if(!isset($error)){


     $query_comentar = sprintf("INSERT INTO SHT_comentario (idUsuario, idPublicacion,contenido) VALUES ('%s','%s','%s')",
     mysqli_real_escape_string($connLocalhost,trim($userData['idUsuario'])),
     mysqli_real_escape_string($connLocalhost,trim($publicacion['idPublicacion'])),
     mysqli_real_escape_string($connLocalhost,trim($_POST['solucion'])));

     $res_insertComentar = mysqli_query($connLocalhost,$query_comentar) or trigger_error("fallo");
    }




  }


  //query buscar comentarios de la publicacion
  $idPublicacion = $publicacion['idPublicacion'];
  $query_comentarios =("SELECT 

  SHT_comentario.contenido AS 'contenido',
  SHT_usuario.nombres AS 'nombres',
  SHT_usuario.idUsuario AS 'idUsuario'
  FROM SHT_comentario
  LEFT JOIN SHT_usuario AS SHT_usuario ON SHT_usuario.idUsuario = SHT_comentario.idUsuario
  WHERE SHT_comentario.idPublicacion = $idPublicacion");
  $res_comentarios = mysqli_query($connLocalhost,$query_comentarios);


  $comentarios = mysqli_fetch_assoc($res_comentarios);

  ?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script type="text/javascript" src="js/responder.js"></script>
    <script type="text/javascript" src="js/likes.js"></script>

</head>

<body>




    <! -- cabecera -->
        <?php include("includes/header.php"); ?>

        <?php include("includes/barraLateral.php"); ?>


        <div class="col-md-9 gedf-main">

            <div class="bg-danger">

                <?php 
if(isset($error)) printMsg($error, "error"); 
?>

            </div>


            <div class="card gedf-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                            </div>
                            <div class="ml-2">
                                <div class="h5 m-0">

                                    <a href="perfil.php?idUsuario=<?php echo $publicacion['idUsuario']?>">
                                        <span class="text-primary"> <?php echo($publicacion['nombre'])?>
                                        </span>
                                    </a>
                                </div>
                                <div class="h7 text-muted"><?php echo($publicacion['apellido'])?></div>
                                <a class="text-dark"
                                    href="grupo.php?idGrupo=<?php echo $publicacion['idGrupo']; ?>">><?php echo($publicacion['grupo'])?></a>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>

                </div>
                <div class="card-body">

                    <h5 class="text-info"><?php echo($publicacion['titulo'])?></h5>

                    <p class="card-text">
                        <?php echo($publicacion['contenido'])?>
                    </p>
                </div>




                <div id="publicacion" class="card-footer">



                    <?php 
                            $query_megusta = sprintf("SELECT * FROM SHT_megustas WHERE idUsuario =%d AND idPublicacion = %d",
                            mysqli_real_escape_string($connLocalhost, trim($userData['idUsuario'])),
                            mysqli_real_escape_string($connLocalhost, trim($publicacion['idPublicacion'])));

                            $resquery_query_megusta = mysqli_query($connLocalhost,$query_megusta) or trigger_error(" la query de megustas fallo");
                            
                            
                            if(mysqli_num_rows($resquery_query_megusta)==0){?>
                    <span class="like text-info"
                        id="cantidad_<?php echo $publicacion['idPublicacion'] ?>"><?php echo $publicacion['megustas']?></span>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                    </svg>

                    <a style="cursor:pointer" class="card-link"><i class="fa fa-gittip"></i><span class="like"
                            id="<?php echo $publicacion['idPublicacion'] ?>">Me gusta</span></a>




                    <?php } else {?>
                    <span class="like text-info"
                        id="cantidad_<?php echo $publicacion['idPublicacion'] ?>"><?php echo $publicacion['megustas']?></span>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" />
                    </svg>

                    <a style="cursor:pointer" class="card-link"><i class="fa fa-gittip"></i><span class="like"
                            id="<?php echo $publicacion['idPublicacion'] ?>">No me gusta</span></a>



                    <?php } ?>

                </div>
            </div>

            <?php if($userData['rol']=='Asesor'){
                
                
                ?>
            <div class="text-center bg-info text-white h1">
                Responder
            </div>

            <form method="POST">

                <div class="form-group">

                    <textarea class="form-control" id="solucion" name="solucion" rows="3"></textarea>

                    <input class="btn btn-info" type="submit" value="Comentar" name="responder_send">


                </div>

            </form>

            <?php }?>



            <div class="text-center bg-info text-white h1">
                Respuestas
            </div>


            <?php
            if(isset($comentarios)){

                    do{
              ?>
            <div class="card gedf-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="ml-2">
                                <div class="h5 m-0">

                                    <a href="perfil.php?idUsuario=<?php echo $comentarios['idUsuario']?>"><?php echo $comentarios['nombres']?>
                                    </a>
                                </div>
                                <div class="h7 text-black"> <?php echo $comentarios['contenido']?></div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }while( $comentarios = mysqli_fetch_assoc($res_comentarios));
                }else{
                    
                
                  ?>
            <div class="text-center text-danger h1">
                Aun no hay respuestas
            </div>

            <?php }?>


            <!-- Post /////-->




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