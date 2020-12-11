<?php
include("../connections/conn_localhost.php");

$idMiembro = $_GET['idMiembro'];
$idGrupo = $_GET['idGrupo'];

$query_eliminar = ("DELETE FROM SHT_miembros WHERE idGrupo=$idGrupo and idUsuario=$idMiembro");
$res = mysqli_query($connLocalhost,$query_eliminar);

header("Location: ../eliminarMiembros-Asesores.php?idGrupo=$idGrupo");

?>