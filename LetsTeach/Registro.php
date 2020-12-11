<?php
  include("connections/conn_localhost.php");


  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['registrar_send'])) {

      // Validamos si las cajas están vacias
  //
    // Validación de passwords coincidentes
    if($_POST['contraseña'] != $_POST['confirmarContraseña']){
      $error[] = "Las contraseñas no son coincidentes";
     
      echo ($error);
  }

    // Validación de email
    // Preparamos la consulta para determinar si el email porporcionado ya existe en la BD
    $queryCheckEmail = sprintf("SELECT idUsuario FROM SHT_usuario WHERE correo = '%s'",
      mysqli_real_escape_string($connLocalhost, trim($_POST['correos']))
    );

    // Ejecutamos el query 
    $resQueryCheckEmail = mysqli_query($connLocalhost, $queryCheckEmail) or trigger_error("El query de validación de email falló"); // Record set o result set siempre y cuando el query sea de tipo SELECT

    // Contar el recordset para determinar si se encontró el correo en la BD
    if(mysqli_num_rows($resQueryCheckEmail)) {
      $error[] = "El correo proporcionado ya está siendo utilizado";
      
    }

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
      // Preparamos la consulta para guardar el registro en la BD
      $queryInsertUser = sprintf("INSERT INTO SHT_usuario (nombres, apellidos, telefono, correo,contraseña,rol,descripcion) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
          mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['apellido'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['telefono'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['correos'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['contraseña'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['tipoUsuario'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['descripcion']))

      );

      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

      // Redireccionamos al usuario al Panel de Control
      header("Location:index.php?insertUser=true");
    }

  }
  else {
    
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Registro Let´s Teach</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2raul.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/registrar.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-foto p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Formato de Registro</h2>
                    <form method="POST">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nombres</label>
                                    <input class="input--style-4" type="text" name="nombre">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Apelidos</label>
                                    <input class="input--style-4" type="text" name="apellido">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Rol</label>
                                    <div class="p-t-10">
                                    <select name="tipoUsuario" id="tipoUsuario">
            
            <option value="Asesor">Asesor</option>
            <option value="Estudiante">Estudiante</option>

        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Numero de Telefono</label>
                                    <input class="input--style-4" type="text" name="telefono">
                                </div>
                            </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">E-mail</label>
                                    <input class="input--style-4" type="email" name="correos">
                                </div>
                                <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Contraseña</label>
                                    <input class="input--style-4" type="password" name="contraseña">
                                </div>
                            </div>
                            <div >
                                <div class="input-group">
                                    <label class="label">Confirmar Contraseña</label>
                                    <input class="input--style-4" type="password" name="confirmarContraseña">
                                </div>
                            </div>
                            
                        </div>
                       
                        <div class="p-t-15">
                            <button name="registrar_send" class="btn btn--radius-2 btn--blue" type="registrar">Registrar</button>
                       
                        </div>
                       
                    </form>
                  
                      

                    <br>
            <a href="login.php" class="h5">¿Ya tienes una cuenta?</a>
                </div>
                
            </div>
           
           
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2raul.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->