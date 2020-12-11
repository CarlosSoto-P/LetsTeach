<?php
  include("connections/conn_localhost.php");

  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
  }
  if(!isset($_SESSION['id'])) header('Location: login.php');
  
  //consultar informacion del usuario
  $query_userData = sprintf("SELECT * FROM SHT_usuario WHERE idUsuario =%d",
  mysqli_real_escape_string($connLocalhost, trim($_SESSION['id']))
  );
  $resQueryUserData = mysqli_query($connLocalhost, $query_userData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");
  $userData= mysqli_fetch_assoc($resQueryUserData);
  

  if($userData['rol']=='Estudiante')  header('Location: index.php');
  if($userData['rol']=='Asesor')  header('Location: indexAsesor.php');


  //consusltar de todos los grupos  
  $query_grupos = sprintf("SELECT * FROM SHT_grupo");
  $res_grupos = mysqli_query($connLocalhost,$query_grupos);

  //consusltar de todos los usuarios  
  $query_usuarios = sprintf("SELECT * FROM SHT_usuario");
  $res_usuarios = mysqli_query($connLocalhost,$query_usuarios);
 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link rel="stylesheet" href="css/fondo.css">

    <title>Index admin</title>
</head>
<body >

    <!-- cabecera -->
    <?php include("includes/headerAdmin.php"); ?>

            <!-- barra lateral -->
            <div class="col-md-3 float-right">
                    
                    <div class="card">
                        <div class="card-body">
                            <h5>Panel de Control</h5>
                            <hr>
                            <ul>

                              

                                <li>
                                    <a href="includes/cerrar_sesion.php" class="card-link">Cerrar Sesion</a>

                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class = "h7">
                                <h5>Usuarios</h5>
                                <hr>
                                <?php
                               while($usuarios= mysqli_fetch_array($res_usuarios)) 
                               { ?>

                               <ul>

                                    <li>
                                    <form method="post">
                                        <a href="perfilAdmin.php?idUsuario=<?php echo $usuarios['idUsuario']?>"
                                            class="text-dark"><?php echo($usuarios['nombres']);?></a>
                                            <br>
                                            
                                    </li>

                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

            </div>


            
    <div class = "fondoAdmin">


        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <div class="col-md-3">

                    <div class="card">

                        <div class="card-body">
                            <div class="h5">
                                <a href="miPerfil.php">
                                    <?php 
                                echo($userData['nombres'].' '.$userData['apellidos'])
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
                            <h5>Grupos</h5>
                            <hr>
                          
                            <div class="h7">
                               <?php
                               while($grupos= mysqli_fetch_array($res_grupos)) 
                               { ?>

                               <ul>

                                    <li>
                                    <form method="post">
                                        <a href="grupoAdmin.php?idGrupo=<?php echo $grupos['idGrupo']; ?>"
                                            class="text-dark"><?php echo($grupos['nombre']);?></a>
                                            <br>
                                            
                                    </li>

                                </ul>
                                <?php } ?>

                            </div>
                         
                            
                        </div>

                    </div>
                    <!--Eliminar grupo -->
                  
                    <?php
                 
                

                    
                    ?>


                </div> 


                            
            </div> 




        </div> 
         
        

    </div>
</body>
</html>